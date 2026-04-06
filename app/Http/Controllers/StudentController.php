<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleCourse;
use App\Models\ScheduleExternalActivity;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct(protected GeminiService $gemini) {}

    /* ─── Dashboard ─── */

    public function dashboard()
    {
        // Load all schedules for the student to support multiple files
        $schedules = auth()->user()
            ->schedules()
            ->with(['courses', 'conflicts', 'recommendations', 'activities'])
            ->latest()
            ->get();

        // Standard schedule for head analytics (still helpful as latest)
        $latestSchedule = $schedules->first();
        
        // Items and Conflicts
        $allItems         = auth()->user()->getAllItems();
        $globalConflicts  = auth()->user()->global_conflicts;

        $dayOrder  = ['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU'];
        $dayColors = [
            'SENIN'  => ['bg'=>'bg-blue-600',    'light'=>'bg-blue-50',    'text'=>'text-blue-900',    'badge'=>'bg-blue-900 text-white',    'border'=>'border-blue-900'],
            'SELASA' => ['bg'=>'bg-violet-600',  'light'=>'bg-violet-50',  'text'=>'text-violet-900',  'badge'=>'bg-violet-900 text-white',  'border'=>'border-violet-900'],
            'RABU'   => ['bg'=>'bg-sky-600',     'light'=>'bg-sky-50',     'text'=>'text-sky-900',     'badge'=>'bg-sky-900 text-white',     'border'=>'border-sky-900'],
            'KAMIS'  => ['bg'=>'bg-emerald-600', 'light'=>'bg-emerald-50', 'text'=>'text-emerald-900', 'badge'=>'bg-emerald-900 text-white', 'border'=>'border-emerald-900'],
            'JUMAT'  => ['bg'=>'bg-amber-600',   'light'=>'bg-amber-50',   'text'=>'text-amber-900',   'badge'=>'bg-amber-900 text-white',   'border'=>'border-amber-900'],
            'SABTU'  => ['bg'=>'bg-rose-600',    'light'=>'bg-rose-50',    'text'=>'text-rose-900',    'badge'=>'bg-rose-900 text-white',    'border'=>'border-rose-900'],
            'MINGGU' => ['bg'=>'bg-slate-600',   'light'=>'bg-slate-50',   'text'=>'text-slate-900',   'badge'=>'bg-slate-900 text-white',   'border'=>'border-slate-900'],
        ];

        $grouped = [];
        foreach ($dayOrder as $d) {
            $dayItems = $allItems->filter(fn($i) => strtoupper($i->day) === $d)->sortBy('time_start');
            if ($dayItems->isNotEmpty()) $grouped[$d] = $dayItems;
        }

        // Live Today Logic
        $now = \Carbon\Carbon::now('Asia/Makassar');
        $mapDayToIndo = [
            0 => 'MINGGU', 1 => 'SENIN', 2 => 'SELASA',
            3 => 'RABU', 4 => 'KAMIS', 5 => 'JUMAT', 6 => 'SABTU'
        ];
        $todayIndo = $mapDayToIndo[$now->dayOfWeek];
        $todayItems = $grouped[$todayIndo] ?? collect([]);
        $ongoingItem = null;
        $currentTime = $now->format('H:i');

        foreach ($todayItems as $item) {
            if ($currentTime >= $item->time_start && $currentTime <= $item->time_end) {
                $ongoingItem = $item;
                break;
            }
        }

        return view('dashboard.student', compact(
            'schedules', 'latestSchedule', 'allItems', 'globalConflicts', 'grouped', 'dayColors',
            'todayIndo', 'todayItems', 'ongoingItem', 'currentTime'
        ));
    }

    /* ─── Upload form ─── */

    public function uploadForm()
    {
        // Allow multiple uploads now
        return view('student.upload');
    }

    /* ─── Handle upload ─── */

    public function upload(Request $request)
    {
        // Allow multiple uploads now
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

    /* ─── Master Mata Kuliah Index ─── */

    public function indexCourses()
    {
        $user      = auth()->user();
        $schedules = $user->schedules()->with('courses')->latest()->get();
        $allCourses = $user->allCourses()->with('schedule')->orderByRaw("FIELD(day,'SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU')")->orderBy('time_start')->get();

        $dayOrder = ['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU'];
        $grouped  = [];
        foreach ($dayOrder as $d) {
            $dayItems = $allCourses->filter(fn($c) => strtoupper($c->day) === $d);
            if ($dayItems->isNotEmpty()) $grouped[$d] = $dayItems;
        }

        $totalCredits  = $allCourses->sum('credits');
        $globalConflicts = $user->global_conflicts;

        return view('student.courses.index', compact('schedules', 'allCourses', 'grouped', 'totalCredits', 'globalConflicts', 'dayOrder'));
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

    /* ─── External Activities (Jobs/Freelance) ─── */

    public function indexActivities()
    {
        $schedule = auth()->user()->schedules()->latest()->with('activities')->first();

        if (!$schedule) {
            return redirect()->route('student.upload')
                ->with('warning', 'Silakan unggah jadwal kuliah terlebih dahulu untuk mengelola agenda pekerjaan/freelance.');
        }

        $activities = $schedule->activities;
        return view('student.activities.index', compact('schedule', 'activities'));
    }

    public function createActivity()
    {
        $schedule = auth()->user()->schedules()->latest()->first();

        if (!$schedule) {
            return redirect()->route('student.upload')
                ->with('warning', 'Silakan unggah jadwal kuliah terlebih dahulu.');
        }

        return view('student.activities.create', compact('schedule'));
    }

    public function storeActivity(Request $request)
    {
        $schedule = auth()->user()->schedules()->latest()->first();
        abort_if(!$schedule, 404);

        $validated = $request->validate([
            'type'        => 'required|string|max:50',
            'title'       => 'required|string|max:255',
            'day'         => 'required|string|max:20',
            'time_start'  => 'required|string|max:5',
            'time_end'    => 'required|string|max:5',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
        ]);

        $schedule->activities()->create($validated);

        return redirect()->route('student.activities.index')
            ->with('success', 'Kegiatan baru berhasil ditambahkan ke jadwal.');
    }

    public function editActivity(ScheduleExternalActivity $activity)
    {
        $schedule = $activity->schedule;
        abort_if($schedule->user_id !== auth()->id(), 403);

        return view('student.activities.edit', compact('schedule', 'activity'));
    }

    public function updateActivity(Request $request, ScheduleExternalActivity $activity)
    {
        $schedule = $activity->schedule;
        abort_if($schedule->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'type'        => 'required|string|max:50',
            'title'       => 'required|string|max:255',
            'day'         => 'required|string|max:20',
            'time_start'  => 'required|string|max:5',
            'time_end'    => 'required|string|max:5',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
        ]);

        $activity->update($validated);

        return redirect()->route('student.activities.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroyActivity(ScheduleExternalActivity $activity)
    {
        $schedule = $activity->schedule;
        abort_if($schedule->user_id !== auth()->id(), 403);

        $activity->delete();

        return redirect()->route('student.activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
