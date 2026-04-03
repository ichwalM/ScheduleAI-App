<x-app-layout title="Students">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-700 dark:text-white">Students</h1>
            <p class="text-slate-400 text-sm">Registered student accounts</p>
        </div>
        <span class="text-sm text-slate-400 bg-slate-100 dark:bg-slate-700 px-3 py-1.5 rounded-full">{{ $students->total() }} total</span>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-700/50">
                    <th class="px-6 py-3">Student</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Joined</th>
                    <th class="px-6 py-3">Schedules</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($students as $student)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <p class="font-medium text-slate-700 dark:text-slate-200">{{ $student->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $student->email }}</td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $student->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-indigo-600">{{ $student->schedules_count }}</span>
                            <span class="text-slate-400 text-xs"> uploads</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">No students registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($students->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">{{ $students->links() }}</div>
        @endif
    </div>
</x-app-layout>
