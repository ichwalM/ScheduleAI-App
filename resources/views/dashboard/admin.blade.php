<x-app-layout title="Admin Dashboard">

    <!-- Stat cards row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        {{-- Total Students --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 group hover:shadow-md transition-shadow">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-indigo-500 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/50 px-2 py-1 rounded-full">Students</span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $totalStudents }}</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Registered students</p>
        </div>

        {{-- Total Courses --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 group hover:shadow-md transition-shadow">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-violet-500 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/50 px-2 py-1 rounded-full">Courses</span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $totalCourses }}</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Active courses</p>
        </div>

        {{-- Pending --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 group hover:shadow-md transition-shadow">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 dark:bg-amber-900/50 px-2 py-1 rounded-full">Pending</span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $pendingSchedules }}</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Awaiting analysis</p>
        </div>

        {{-- Analyzed --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 group hover:shadow-md transition-shadow">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/50 px-2 py-1 rounded-full">Done</span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $analyzedSchedules }}</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Analyzed schedules</p>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <a href="{{ route('admin.courses.create') }}"
           class="flex items-center gap-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-2xl p-5 shadow-md hover:shadow-lg transition-all group">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Add New Course</p>
                <p class="text-indigo-200 text-xs">Create a course record</p>
            </div>
        </a>
        <a href="{{ route('admin.schedules') }}"
           class="flex items-center gap-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-700 dark:text-slate-200">View All Schedules</p>
                <p class="text-slate-400 text-xs">Student submissions</p>
            </div>
        </a>
        <a href="{{ route('admin.students') }}"
           class="flex items-center gap-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-700 dark:text-slate-200">Manage Students</p>
                <p class="text-slate-400 text-xs">View student accounts</p>
            </div>
        </a>
    </div>

    <!-- Recent submissions table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="font-semibold text-slate-700 dark:text-white">Recent Submissions</h2>
            <a href="{{ route('admin.schedules') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View all →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-700/50">
                        <th class="px-6 py-3">Student</th>
                        <th class="px-6 py-3">File</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Uploaded</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($recentSchedules as $schedule)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-semibold text-xs">
                                        {{ strtoupper(substr($schedule->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-slate-200">{{ $schedule->user->name }}</p>
                                        <p class="text-slate-400 text-xs">{{ $schedule->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                {{ basename($schedule->file_path) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($schedule->status === 'analyzed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Analyzed
                                    </span>
                                @elseif($schedule->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $schedule->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.schedules.show', $schedule) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">View Report</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                No submissions yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
