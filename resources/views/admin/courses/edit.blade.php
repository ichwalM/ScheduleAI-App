<x-app-layout title="Edit Course">
    <div class="max-w-xl mx-auto">
        <a href="{{ route('admin.courses') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-indigo-600 mb-6 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Courses
        </a>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <h1 class="text-lg font-bold text-slate-700 dark:text-white mb-6">Edit Course — {{ $course->name }}</h1>
            <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Course Name</label>
                    <input type="text" name="name" value="{{ old('name', $course->name) }}"
                           class="w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Course Code</label>
                        <input type="text" name="code" value="{{ old('code', $course->code) }}"
                               class="w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white" required>
                        @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Credits (SKS)</label>
                        <input type="number" name="credits" value="{{ old('credits', $course->credits) }}" min="1" max="6"
                               class="w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white" required>
                        @error('credits') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white resize-none">{{ old('description', $course->description) }}</textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition-colors shadow">
                    Update Course
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
