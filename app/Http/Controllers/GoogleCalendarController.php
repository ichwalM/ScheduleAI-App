<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Carbon\Carbon;

class GoogleCalendarController extends Controller
{
    /**
     * Get configured Google Client
     */
    private function getClient()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id', env('GOOGLE_CLIENT_ID')));
        $client->setClientSecret(config('services.google.client_secret', env('GOOGLE_CLIENT_SECRET')));
        $client->setRedirectUri(config('services.google.redirect', env('GOOGLE_REDIRECT_URI')));
        $client->addScope(Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent'); // Force to return refresh token
        return $client;
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        abort_if(!env('GOOGLE_CLIENT_ID'), 400, 'Google Client ID belum dikonfigurasi di .env');
        
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    /**
     * Handle OAuth Callback
     */
    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('student.dashboard')->with('error', 'Integrasi Google Calendar dibatalkan.');
        }

        $client = $this->getClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

        if (array_key_exists('error', $token)) {
            return redirect()->route('student.dashboard')->with('error', 'Gagal mendapatkan token dari Google.');
        }

        $user = auth()->user();
        $user->google_token = json_encode($token);
        
        if (isset($token['refresh_token'])) {
            $user->google_refresh_token = $token['refresh_token'];
        }

        // Just to get the user's google ID (optional, using OAuth2 service)
        // We will skip it for now and just save the token to the user auth object
        $user->save();

        return redirect()->route('student.dashboard')->with('success', 'Berhasil terhubung ke Google Calendar!');
    }

    /**
     * Sync Schedule to Google Calendar
     */
    public function sync(Schedule $schedule)
    {
        $user = auth()->user();

        if (!$user->google_token) {
            return redirect()->route('student.dashboard')->with('error', 'Kamu harus menghubungkan Google Calendar terlebih dahulu.');
        }

        $client = $this->getClient();
        $client->setAccessToken($user->google_token);

        if ($client->isAccessTokenExpired()) {
            if ($user->google_refresh_token) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                $user->google_token = json_encode($newToken);
                $user->save();
            } else {
                return redirect()->route('google.redirect')->with('warning', 'Sesi Google kamu telah kedaluwarsa. Silakan hubungkan ulang.');
            }
        }

        $service = new Calendar($client);

        // Prep days map to English for strtotime / Carbon
        $mapDays = [
            'SENIN' => 'Monday',
            'SELASA' => 'Tuesday',
            'RABU' => 'Wednesday',
            'KAMIS' => 'Thursday',
            'JUMAT' => 'Friday',
            'SABTU' => 'Saturday',
            'MINGGU' => 'Sunday'
        ];

        // Combine courses and activities
        $items = collect();
        foreach ($schedule->courses as $c) {
            $c->is_activity = false;
            $items->push($c);
        }
        foreach ($schedule->activities as $a) {
            $a->is_activity = true;
            $items->push($a);
        }

        $count = 0;

        foreach ($items as $item) {
            $dayName = strtoupper($item->day);
            if (!isset($mapDays[$dayName])) continue;

            $englishDay = $mapDays[$dayName];

            // Get next occurrence of this day
            // E.g. If today is Monday, "next Monday" will be next week, so we use current date if it matches
            $startDate = Carbon::parse("next $englishDay");
            if (Carbon::now()->englishDayOfWeek === $englishDay) {
                $startDate = Carbon::today();
            }

            // Create Event
            $event = new Event([
                'summary' => $item->is_activity ? $item->title : $item->name,
                'location' => $item->is_activity ? ($item->location ?? '') : ($item->room ?? ''),
                'description' => $item->is_activity ? ($item->description ?? '') : "Dosen: " . ($item->lecturer ?? 'Tidak Diketahui') . " - SKS: " . ($item->credits ?? '-'),
                'start' => [
                    'dateTime' => $startDate->format('Y-m-d') . 'T' . $item->time_start . ':00',
                    'timeZone' => 'Asia/Makassar',
                ],
                'end' => [
                    'dateTime' => $startDate->format('Y-m-d') . 'T' . $item->time_end . ':00',
                    'timeZone' => 'Asia/Makassar',
                ],
                'recurrence' => [
                    // Repeat weekly for 16 occurrences (approx 1 semester)
                    'RRULE:FREQ=WEEKLY;COUNT=16'
                ],
            ]);

            try {
                $service->events->insert('primary', $event);
                $count++;
            } catch (\Exception $e) {
                // Log or ignore single event failure
                continue;
            }
        }

        return back()->with('success', "$count jadwal berhasil diskronisasikan ke Google Calendar (diset berulang selama 16 minggu).");
    }
}
