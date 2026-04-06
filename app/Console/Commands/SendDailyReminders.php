<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\DailyScheduleReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek dan mengirimkan email pengingat jadwal harian untuk semua mahasiswa.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Menjalankan Daily Reminder Checker...");

        $now = Carbon::now('Asia/Makassar'); // WITA
        $englishDay = $now->englishDayOfWeek;

        // Map english to indonesian
        $mapDays = [
            'Monday' => 'SENIN',
            'Tuesday' => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday' => 'KAMIS',
            'Friday' => 'JUMAT',
            'Saturday' => 'SABTU',
            'Sunday' => 'MINGGU'
        ];

        $todayIndo = $mapDays[$englishDay] ?? null;

        if (!$todayIndo) {
            $this->error("Gagal mendapatkan nama hari.");
            return;
        }

        $this->info("Hari ini adalah $todayIndo.");

        $users = User::where('role', 'student')->get();
        $sentCount = 0;

        foreach ($users as $user) {
            $allItems = clone $user->allCourses;
            $allActivities = clone $user->allActivities;
            
            // Mark is_activity
            foreach ($allItems as $c) { $c->is_activity = false; }
            foreach ($allActivities as $a) { $a->is_activity = true; }

            // Combine
            $merged = $allItems->concat($allActivities);

            // Filter for today only
            $todayItems = $merged->filter(function($i) use ($todayIndo) {
                return strtoupper($i->day) === $todayIndo;
            })->sortBy('time_start');

            if ($todayItems->isNotEmpty() && $user->email) {
                try {
                    Mail::to($user->email)->send(new DailyScheduleReminder($user, $todayItems, $todayIndo));
                    $sentCount++;
                    $this->line("-> Terkirim ke: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Gagal kirim ke {$user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("Selesai! $sentCount email pengingat telah dikirim.");
    }
}
