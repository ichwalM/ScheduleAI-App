<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /* ─── Profile Hub (homepage for admin) ─── */

    public function profiles()
    {
        $students = User::where('role', 'student')
            ->withCount('schedules')
            ->with(['schedules' => fn($q) => $q->where('status', 'analyzed')->latest()->limit(1)])
            ->latest()
            ->get();

        return view('admin.profiles', compact('students'));
    }

    /* ─── Dashboard ─── */

    public function dashboard()
    {
        $totalStudents     = User::where('role', 'student')->count();
        $totalCourses      = Course::count();
        $pendingSchedules  = Schedule::where('status', 'pending')->count();
        $analyzedSchedules = Schedule::where('status', 'analyzed')->count();
        $recentSchedules   = Schedule::with('user')->latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalStudents',
            'totalCourses',
            'pendingSchedules',
            'analyzedSchedules',
            'recentSchedules'
        ));
    }

    /* ─── Courses CRUD ─── */

    public function courses()
    {
        $courses = Course::latest()->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        return view('admin.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:courses',
            'credits'     => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function editCourse(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:courses,code,' . $course->id,
            'credits'     => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    /* ─── Student Schedules ─── */

    public function schedules(Request $request)
    {
        $query = Schedule::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->paginate(20);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function showSchedule(Schedule $schedule)
    {
        $schedule->load(['user', 'courses', 'conflicts', 'recommendations']);
        return view('admin.schedules.show', compact('schedule'));
    }

    /* ─── Students ─── */

    public function students()
    {
        $students = User::where('role', 'student')->withCount('schedules')->latest()->paginate(20);
        return view('admin.students', compact('students'));
    }
}
