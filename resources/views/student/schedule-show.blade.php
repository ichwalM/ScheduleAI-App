<x-app-layout title="Detail Analisis Jadwal">

{{-- ─── Back link ─── --}}
<a href="{{ route('student.dashboard') }}"
   class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 mb-6 font-medium transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali ke Dashboard
</a>

@if($schedule->status === 'analyzed' && $schedule->courses->count())

    @php
        $dayOrder  = ['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'];
        $dayColors = [
            'SENIN'  => ['bg'=>'bg-blue-500',    'light'=>'bg-blue-50 dark:bg-blue-900/20',    'text'=>'text-blue-700 dark:text-blue-300',    'badge'=>'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',    'border'=>'border-blue-200 dark:border-blue-800'],
            'SELASA' => ['bg'=>'bg-violet-500',   'light'=>'bg-violet-50 dark:bg-violet-900/20', 'text'=>'text-violet-700 dark:text-violet-300', 'badge'=>'bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300', 'border'=>'border-violet-200 dark:border-violet-800'],
            'RABU'   => ['bg'=>'bg-sky-500',      'light'=>'bg-sky-50 dark:bg-sky-900/20',       'text'=>'text-sky-700 dark:text-sky-300',       'badge'=>'bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300',       'border'=>'border-sky-200 dark:border-sky-800'],
            'KAMIS'  => ['bg'=>'bg-emerald-500',  'light'=>'bg-emerald-50 dark:bg-emerald-900/20','text'=>'text-emerald-700 dark:text-emerald-300','badge'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300','border'=>'border-emerald-200 dark:border-emerald-800'],
            'JUMAT'  => ['bg'=>'bg-amber-500',    'light'=>'bg-amber-50 dark:bg-amber-900/20',   'text'=>'text-amber-700 dark:text-amber-300',   'badge'=>'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',   'border'=>'border-amber-200 dark:border-amber-800'],
            'SABTU'  => ['bg'=>'bg-rose-500',     'light'=>'bg-rose-50 dark:bg-rose-900/20',     'text'=>'text-rose-700 dark:text-rose-300',     'badge'=>'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300',     'border'=>'border-rose-200 dark:border-rose-800'],
        ];

        $grouped = [];
        foreach ($dayOrder as $d) {
            $dc = $schedule->courses->filter(fn($c) => strtoupper($c->day) === $d);
            if ($dc->isNotEmpty()) $grouped[$d] = $dc;
        }
        $activeDays    = count($grouped);
        $totalCredits  = $schedule->total_credits ?: $schedule->courses->sum('credits');
        $conflictCount = $schedule->conflict_count ?: $schedule->conflicts->count();
    @endphp

    {{-- ═══ STUDENT INFO CARD ═══ --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 mb-6 text-white relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-10 -left-4 w-32 h-32 bg-white/5 rounded-full"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl font-bold shrink-0">
                {{ strtoupper(substr($schedule->student_name ?? auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-xl font-bold truncate">{{ $schedule->student_name ?? auth()->user()->name }}</h1>
                <p class="text-blue-200 text-sm">{{ $schedule->nim ?? '' }}</p>
                <p class="text-blue-100 text-sm mt-0.5">{{ $schedule->program ?? '' }}</p>
            </div>
            <div class="flex flex-col gap-2 text-sm shrink-0">
                @if($schedule->semester)
                    <span class="inline-flex items-center gap-1.5 bg-white/15 rounded-lg px-3 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $schedule->semester }}
                    </span>
                @endif
                @if($schedule->period)
                    <span class="inline-flex items-center gap-1.5 bg-white/15 rounded-lg px-3 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $schedule->period }}
                    </span>
                @endif
                @if($schedule->advisor)
                    <span class="inline-flex items-center gap-1.5 bg-white/15 rounded-lg px-3 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $schedule->advisor }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ SUMMARY STATS ═══ --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <div><p class="text-2xl font-bold text-slate-800 dark:text-white leading-none">{{ $totalCredits }}</p><p class="text-xs text-slate-500 mt-0.5">Total SKS</p></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/40 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div><p class="text-2xl font-bold text-slate-800 dark:text-white leading-none">{{ $schedule->courses->count() }}</p><p class="text-xs text-slate-500 mt-0.5">Mata Kuliah</p></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-sky-100 dark:bg-sky-900/40 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div><p class="text-2xl font-bold text-slate-800 dark:text-white leading-none">{{ $activeDays }}</p><p class="text-xs text-slate-500 mt-0.5">Hari Aktif</p></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border {{ $conflictCount > 0 ? 'border-red-200 dark:border-red-800' : 'border-emerald-200 dark:border-emerald-800' }} p-4 flex items-center gap-3">
            <div class="w-10 h-10 {{ $conflictCount > 0 ? 'bg-red-100 dark:bg-red-900/40' : 'bg-emerald-100 dark:bg-emerald-900/40' }} rounded-xl flex items-center justify-center shrink-0">
                @if($conflictCount > 0)
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                @else
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                @endif
            </div>
            <div>
                <p class="text-2xl font-bold {{ $conflictCount > 0 ? 'text-red-600' : 'text-emerald-600' }} leading-none">{{ $conflictCount > 0 ? $conflictCount : '✓' }}</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ $conflictCount > 0 ? 'Konflik Jadwal' : 'Aman' }}</p>
            </div>
        </div>
    </div>

    {{-- ═══ JADWAL MINGGUAN ═══ --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 mb-6 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-700">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div><h2 class="font-semibold text-slate-700 dark:text-white">Jadwal Perkuliahan</h2><p class="text-xs text-slate-400">Dikelompokkan berdasarkan hari</p></div>
            <div class="ml-auto flex items-center gap-2">
                <span class="text-xs font-medium bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-2 py-1 rounded-full">{{ $schedule->courses->count() }} mata kuliah</span>
                <a href="{{ route('student.course.create', $schedule) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-lg transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah MK
                </a>
            </div>
        </div>

        <div class="p-6 space-y-6">
            @foreach($grouped as $day => $dayCourses)
                @php $c = $dayColors[$day] ?? $dayColors['SENIN']; @endphp
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-2.5 h-2.5 rounded-full {{ $c['bg'] }}"></div>
                        <h3 class="font-bold text-sm uppercase tracking-widest {{ $c['text'] }}">{{ $day }}</h3>
                        <div class="flex-1 h-px bg-slate-100 dark:bg-slate-700"></div>
                        <span class="text-xs {{ $c['badge'] }} px-2 py-0.5 rounded-full font-medium">{{ $dayCourses->count() }} kelas</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                        @foreach($dayCourses as $course)
                            <div class="group/card rounded-xl border {{ $c['border'] }} {{ $c['light'] }} p-4 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold {{ $c['badge'] }} px-2.5 py-1 rounded-lg">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $course->time_start }} – {{ $course->time_end }}
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-mono font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md">{{ $course->room ?? '—' }}</span>
                                        {{-- Edit button --}}
                                        <a href="{{ route('student.course.edit', [$schedule, $course]) }}"
                                           class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                           title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        {{-- Delete course button --}}
                                        <form action="{{ route('student.course.destroy', [$schedule, $course]) }}" method="POST"
                                              x-data @submit.prevent="if(confirm('Hapus mata kuliah ini?')) $el.submit()">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="font-semibold text-slate-800 dark:text-slate-100 text-sm leading-snug mb-1 line-clamp-2">{{ $course->name }}</p>
                                <div class="flex items-center gap-2 mb-2.5">
                                    <code class="text-xs text-slate-400 font-mono">{{ $course->code ?? '' }}</code>
                                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                    <span class="text-xs font-medium text-slate-500">Kelas {{ $course->class ?? '' }}</span>
                                    <span class="ml-auto text-xs font-bold {{ $c['text'] }}">{{ $course->credits }} SKS</span>
                                </div>
                                @if($course->lecturer)
                                    <div class="flex items-center gap-1.5 pt-2.5 border-t {{ $c['border'] }}">
                                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $course->lecturer }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- ═══ KONFLIK ═══ --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-8 h-8 {{ $conflictCount > 0 ? 'bg-red-100' : 'bg-emerald-100' }} rounded-lg flex items-center justify-center">
                    @if($conflictCount > 0)
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    @else
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <h2 class="font-semibold text-slate-700 dark:text-white">Konflik Jadwal</h2>
            </div>
            <div class="p-6">
                @if($schedule->conflicts->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($schedule->conflicts as $conflict)
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                @if($conflict->day)<p class="text-xs font-bold text-red-400 uppercase tracking-wider mb-1">{{ $conflict->day }}</p>@endif
                                <p class="text-sm font-medium text-red-700 dark:text-red-300 mb-2">{{ $conflict->description }}</p>
                                @if(!empty($conflict->courses_involved))
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($conflict->courses_involved as $ci)
                                            <span class="text-xs bg-red-100 dark:bg-red-900/40 text-red-700 px-2 py-0.5 rounded-md font-medium">{{ $ci }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Jadwal Bebas Konflik</p>
                        <p class="text-xs text-slate-400 mt-1">Tidak ditemukan tumpang tindih jadwal.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══ REKOMENDASI ═══ --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-8 h-8 bg-amber-100 dark:bg-amber-900/40 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h2 class="font-semibold text-slate-700 dark:text-white">Rekomendasi AI</h2>
            </div>
            <div class="p-6">
                @if($schedule->recommendations->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach($schedule->recommendations as $rec)
                            <li class="flex gap-3">
                                <span class="shrink-0 w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 flex items-center justify-center text-xs font-bold">{{ $loop->iteration }}</span>
                                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $rec->content }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <p class="text-sm text-slate-400">Tidak ada rekomendasi tambahan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ AKSI FILE ═══ --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 flex flex-col sm:flex-row items-center gap-4">
        @php $ext = strtolower(pathinfo($schedule->file_path, PATHINFO_EXTENSION)); @endphp
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-slate-700 dark:text-slate-200 truncate">{{ basename($schedule->file_path) }}</p>
                <p class="text-xs text-slate-400">Diunggah {{ $schedule->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ Storage::disk($schedule->file_disk)->url($schedule->file_path) }}" target="_blank"
               class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 py-2 px-4 rounded-xl hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh File
            </a>
            <form action="{{ route('student.schedule.destroy', $schedule) }}" method="POST"
                  x-data @submit.prevent="if(confirm('Hapus jadwal ini secara permanen?')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-red-600 border border-red-200 py-2 px-4 rounded-xl hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

{{-- ═══ PENDING ═══ --}}
@elseif($schedule->status === 'pending')
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-16 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
        <h2 class="font-bold text-slate-700 dark:text-slate-200 mb-2 text-lg">Analisis Sedang Berjalan…</h2>
        <p class="text-slate-400 text-sm max-w-sm">Gemini AI sedang membaca dan menganalisis jadwal Anda.</p>
    </div>

{{-- ═══ FAILED ═══ --}}
@else
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-16 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="font-bold text-slate-700 dark:text-slate-200 mb-2 text-lg">Analisis Gagal</h2>
        <p class="text-slate-400 text-sm max-w-sm mb-6">Terjadi kesalahan saat menganalisis file ini. Silakan coba unggah ulang.</p>
        <a href="{{ route('student.upload') }}" class="bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-xl hover:bg-blue-700 transition-colors">
            Unggah Ulang
        </a>
    </div>
@endif

</x-app-layout>
