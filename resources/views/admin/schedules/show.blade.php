<x-app-layout title="Schedule Report">

    <a href="{{ route('admin.schedules') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-indigo-600 mb-6 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Schedules
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student / file info -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 h-fit">
            <h2 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-4">Submission Info</h2>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-bold">
                    {{ strtoupper(substr($schedule->user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-slate-700 dark:text-slate-200">{{ $schedule->user->name }}</p>
                    <p class="text-slate-400 text-xs">{{ $schedule->user->email }}</p>
                </div>
            </div>
            @php $ext = strtolower(pathinfo($schedule->file_path, PATHINFO_EXTENSION)); @endphp
            @if(in_array($ext, ['jpg','jpeg','png']))
                <img src="{{ Storage::disk($schedule->file_disk)->url($schedule->file_path) }}"
                     alt="Schedule" class="w-full rounded-xl mb-4 border border-slate-200 dark:border-slate-600 object-cover max-h-52">
            @endif
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">File</dt>
                    <dd class="text-slate-700 dark:text-slate-200 truncate max-w-[140px] font-medium">{{ basename($schedule->file_path) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Uploaded</dt>
                    <dd class="text-slate-700 dark:text-slate-200">{{ $schedule->created_at->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-slate-500">Status</dt>
                    <dd>
                        @if($schedule->status === 'analyzed')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Analyzed
                            </span>
                        @elseif($schedule->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span> Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Failed
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- AI Report -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-violet-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h2 class="font-semibold text-slate-700 dark:text-white">Gemini AI Report</h2>
            </div>
            <div class="p-6">
                @if($schedule->ai_analysis_report)
                    <div class="prose prose-sm dark:prose-invert max-w-none prose-headings:text-indigo-700 dark:prose-headings:text-indigo-400">
                        {!! $schedule->ai_analysis_report !!}
                    </div>
                @else
                    <p class="text-slate-400 text-sm text-center py-10">No AI report available yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
