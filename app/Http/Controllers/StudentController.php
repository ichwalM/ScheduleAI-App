<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleCourse;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct(protected GeminiService $gemini) {}

    /* ─── Dashboard ─── */

    public function dashboard()
    {
        // Strictly one schedule per student – get it (any status)
        $schedule = auth()->user()
            ->schedules()
            ->with(['courses', 'conflicts', 'recommendations'])
            ->latest()
            ->first();

        return view('dashboard.student', compact('schedule'));
    }

    /* ─── Upload form ─── */

    public function uploadForm()
    {
        // Block access if a schedule already exists
        $existing = auth()->user()->schedules()->latest()->first();

        if ($existing) {
            return redirect()->route('student.dashboard')
                ->with('warning', 'Kamu sudah memiliki jadwal. Hapus jadwal yang ada terlebih dahulu sebelum mengunggah yang baru.');
        }

        return view('student.upload');
    }

    /* ─── Handle upload ─── */

    public function upload(Request $request)
    {
        // Double-check: block if already has a schedule
        if (auth()->user()->schedules()->exists()) {
            return redirect()->route('student.dashboard')
                ->with('warning', 'Kamu sudah memiliki jadwal. Hapus jadwal yang ada terlebih dahulu sebelum mengunggah yang baru.');
        }

        $request->validate([
            'schedule_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:10240'],
        ]);

        $file     = $request->file('schedule_file');
        $mimeType = $file->getMimeType();
        $path     = $file->store('schedules', 'public');

        $schedule = auth()->user()->schedules()->create([
            'file_path' => $path,
            'file_disk' => 'public',
            'status'    => 'pending',
        ]);

        $absolutePath = Storage::disk('public')->path($path);
        $result       = $this->gemini->analyzeSchedule($absolutePath, $mimeType);

        if ($result && ($result['success'] ?? false)) {
            $data = $result['data'];

            $schedule->update([
                'ai_analysis_report' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status'             => 'analyzed',
                'student_name'       => $data['student']['name']    ?? null,
                'nim'                => $data['student']['nim']      ?? null,
                'program'            => $data['student']['program']  ?? null,
                'semester'           => $data['student']['semester'] ?? null,
                'advisor'            => $data['student']['advisor']  ?? null,
                'period'             => $data['student']['period']   ?? null,
                'total_credits'      => $data['total_credits']       ?? 0,
                'conflict_count'     => $data['conflict_count']      ?? 0,
            ]);

            foreach ($data['courses'] ?? [] as $c) {
                $schedule->courses()->create([
                    'day'        => strtoupper($c['day']      ?? ''),
                    'name'       => $c['name']      ?? '',
                    'code'       => $c['code']       ?? null,
                    'credits'    => $c['credits']    ?? 3,
                    'class'      => $c['class']      ?? null,
                    'lecturer'   => $c['lecturer']   ?? null,
                    'time_start' => $c['time_start'] ?? null,
                    'time_end'   => $c['time_end']   ?? null,
                    'room'       => $c['room']        ?? null,
                ]);
            }

            foreach ($data['conflicts'] ?? [] as $cf) {
                $schedule->conflicts()->create([
                    'day'              => $cf['day']             ?? null,
                    'description'      => $cf['description']     ?? '',
                    'courses_involved' => $cf['courses_involved'] ?? [],
                ]);
            }

            foreach ($data['recommendations'] ?? [] as $i => $rec) {
                $schedule->recommendations()->create([
                    'content'    => $rec,
                    'sort_order' => $i,
                ]);
            }

            return redirect()->route('student.schedule.show', $schedule)
                ->with('success', 'Jadwal berhasil diunggah dan dianalisis!');
        }

        $schedule->update(['status' => 'failed']);

        return redirect()->route('student.dashboard')
            ->with('warning', 'Jadwal berhasil diunggah tetapi analisis gagal. ' . ($result['error'] ?? 'Coba lagi nanti.'));
    }

    /* ─── Show schedule detail ─── */

    public function show(Schedule $schedule)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);

        $schedule->load(['courses', 'conflicts', 'recommendations']);

        return view('student.schedule-show', compact('schedule'));
    }

    /* ─── Edit schedule info (student/semester/advisor/period) ─── */

    public function editSchedule(Schedule $schedule)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);

        return view('student.schedule-edit', compact('schedule'));
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'student_name' => 'nullable|string|max:255',
            'nim'          => 'nullable|string|max:30',
            'program'      => 'nullable|string|max:255',
            'semester'     => 'nullable|string|max:60',
            'advisor'      => 'nullable|string|max:255',
            'period'       => 'nullable|string|max:100',
        ]);

        $schedule->update($validated);

        return redirect()->route('student.schedule.show', $schedule)
            ->with('success', 'Informasi jadwal berhasil diperbarui.');
    }

    /* ─── Edit a single course ─── */

    public function editCourse(Schedule $schedule, ScheduleCourse $course)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);
        abort_if($course->schedule_id !== $schedule->id, 403);

        return view('student.course-edit', compact('schedule', 'course'));
    }

    public function updateCourse(Request $request, Schedule $schedule, ScheduleCourse $course)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);
        abort_if($course->schedule_id !== $schedule->id, 403);

        $validated = $request->validate([
            'day'        => 'required|string|max:20',
            'name'       => 'required|string|max:255',
            'code'       => 'nullable|string|max:50',
            'credits'    => 'required|integer|min:1|max:10',
            'class'      => 'nullable|string|max:20',
            'lecturer'   => 'nullable|string|max:255',
            'time_start' => 'required|string|max:5',
            'time_end'   => 'required|string|max:5',
            'room'       => 'nullable|string|max:50',
        ]);

        $course->update($validated);

        $schedule->update([
            'total_credits' => $schedule->courses()->sum('credits'),
        ]);

        return redirect()->route('student.schedule.show', $schedule)
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    /* ─── Add new course to schedule ─── */

    public function createCourse(Schedule $schedule)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);

        return view('student.course-create', compact('schedule'));
    }

    public function storeCourse(Request $request, Schedule $schedule)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'day'        => 'required|string|max:20',
            'name'       => 'required|string|max:255',
            'code'       => 'nullable|string|max:50',
            'credits'    => 'required|integer|min:1|max:10',
            'class'      => 'nullable|string|max:20',
            'lecturer'   => 'nullable|string|max:255',
            'time_start' => 'required|string|max:5',
            'time_end'   => 'required|string|max:5',
            'room'       => 'nullable|string|max:50',
        ]);

        $schedule->courses()->create($validated);

        $schedule->update([
            'total_credits' => $schedule->courses()->sum('credits'),
        ]);

        return redirect()->route('student.schedule.show', $schedule)
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    /* ─── Delete a single course ─── */

    public function destroyCourse(Schedule $schedule, ScheduleCourse $course)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);
        abort_if($course->schedule_id !== $schedule->id, 403);

        $course->delete();

        $schedule->update([
            'total_credits' => $schedule->courses()->sum('credits'),
        ]);

        return redirect()->route('student.schedule.show', $schedule)
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }

    /* ─── Delete schedule ─── */

    public function destroy(Schedule $schedule)
    {
        abort_if($schedule->user_id !== auth()->id(), 403);

        Storage::disk($schedule->file_disk)->delete($schedule->file_path);
        $schedule->delete(); // cascades

        return redirect()->route('student.dashboard')
            ->with('success', 'Jadwal berhasil dihapus. Kamu sekarang bisa mengunggah jadwal baru.');
    }
}
