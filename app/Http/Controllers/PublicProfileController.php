<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    /**
     * Tampilkan jadwal publik seorang mahasiswa berdasarkan nama.
     * URL: /{username}  e.g., localhost:8000/ichwal
     */
    public function show(string $username)
    {
        // Cari user berdasarkan name (case-insensitive, slug-friendly)
        $user = User::where('role', 'student')
            ->whereRaw('LOWER(REPLACE(name, " ", "")) = ?', [strtolower(str_replace(' ', '', $username))])
            ->with(['schedules.courses', 'schedules.activities', 'schedules.conflicts'])
            ->first();

        if (!$user) {
            abort(404, 'Profil tidak ditemukan.');
        }

        $schedules     = $user->schedules()->where('status', 'analyzed')->latest()->get();
        $allItems      = $user->getAllItems();
        $globalConflicts = $user->global_conflicts;

        // Hari-hari yang ada jadwalnya (dari semua jadwal)
        $dayOrder = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'];
        $grouped  = [];
        foreach ($dayOrder as $d) {
            $dayItems = $allItems->filter(fn($i) => strtoupper($i->day) === $d)->sortBy('time_start');
            if ($dayItems->isNotEmpty()) $grouped[$d] = $dayItems;
        }

        return view('public.profile', compact('user', 'schedules', 'allItems', 'globalConflicts', 'grouped', 'dayOrder'));
    }
}
