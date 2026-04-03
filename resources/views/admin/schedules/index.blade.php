<x-app-layout title="All Schedules">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-700 dark:text-white">Student Schedules</h1>
            <p class="text-slate-400 text-sm">All uploaded schedule submissions</p>
        </div>
        <!-- Status filter -->
        <form method="GET" action="{{ route('admin.schedules') }}" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()"
                    class="border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl px-3 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Statuses</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="analyzed" {{ request('status') === 'analyzed' ? 'selected' : '' }}>Analyzed</option>
                <option value="failed"   {{ request('status') === 'failed'   ? 'selected' : '' }}>Failed</option>
            </select>
        </form>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
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
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-semibold text-xs">
                                        {{ strtoupper(substr($schedule->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-slate-200">{{ $schedule->user->name }}</p>
                                        <p class="text-slate-400 text-xs">{{ $schedule->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-[200px] truncate">{{ basename($schedule->file_path) }}</td>
                            <td class="px-6 py-4">
                                @if($schedule->status === 'analyzed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Analyzed
                                    </span>
                                @elseif($schedule->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $schedule->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.schedules.show', $schedule) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">View Report →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">No schedules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($schedules->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">{{ $schedules->links() }}</div>
        @endif
    </div>
</x-app-layout>
