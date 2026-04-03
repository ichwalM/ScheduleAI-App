<x-app-layout title="Manage Courses">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-700 dark:text-white">Courses</h1>
            <p class="text-slate-400 text-sm">Manage your university course catalog</p>
        </div>
        <a href="{{ route('admin.courses.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl transition-colors shadow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Course
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-700/50">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Code</th>
                    <th class="px-6 py-3">Credits</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($courses as $course)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-slate-400">{{ $course->id }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 dark:text-slate-200">{{ $course->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-400 rounded font-mono text-xs">{{ $course->code }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $course->credits }} SKS</td>
                        <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $course->description ?? '–' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.courses.edit', $course) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium transition-colors text-xs">Edit</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                      x-data @submit.prevent="if(confirm('Delete this course?')) $el.submit()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition-colors text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            No courses yet. <a href="{{ route('admin.courses.create') }}" class="text-indigo-600">Create one.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($courses->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">{{ $courses->links() }}</div>
        @endif
    </div>
</x-app-layout>
