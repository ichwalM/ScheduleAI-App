<x-app-layout title="Manajemen Mata Kuliah">

    <style>
        .sharp-card  { border-radius: 0 !important; border: 2px solid #000; background: #fff; }
        .conflict-dot { width: 8px; height: 8px; background: #dc2626; display: inline-block; flex-shrink: 0; }
    </style>

    {{-- ═══ HERO ═══ --}}
    <div class="relative w-full h-36 bg-slate-900 overflow-hidden mb-8 border-b-4 border-blue-600">
        <div class="relative z-10 h-full flex flex-col justify-center px-10 border-l-8 border-blue-600">
            <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-1">Student Terminal — Mata Kuliah</p>
            <h1 class="text-4xl font-black text-white uppercase tracking-tighter leading-none">
                Manajemen Mata Kuliah
            </h1>
            <p class="text-white/50 text-[10px] font-bold uppercase tracking-widest mt-2">
                {{ $allCourses->count() }} MK &nbsp;•&nbsp; {{ $totalCredits }} SKS &nbsp;•&nbsp;
                @if($globalConflicts->count() > 0)
                    <span class="text-red-400">{{ $globalConflicts->count() }} KONFLIK GLOBAL</span>
                @else
                    <span class="text-emerald-400">TIDAK ADA KONFLIK</span>
                @endif
            </p>
        </div>
    </div>

    {{-- ═══ GLOBAL CONFLICT ALERT ═══ --}}
    @if($globalConflicts->count() > 0)
    <div class="flex items-center gap-4 border-4 border-red-600 bg-red-50 p-5 mb-8">
        <div class="w-10 h-10 bg-red-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-black text-red-600 uppercase tracking-tight mb-0.5">TABRAKAN JADWAL TERDETEKSI</p>
            <p class="text-[11px] text-red-700 font-bold uppercase">{{ $globalConflicts->count() }} item saling tumpang tindih. Item konflik ditandai dengan label merah.</p>
        </div>
    </div>
    @endif

    {{-- ═══ STATS ROW ═══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="sharp-card p-6 border-b-4 border-blue-600" style="box-shadow: 4px 4px 0px #1e40af;">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Mata Kuliah</p>
            <p class="text-3xl font-black">{{ $allCourses->count() }}</p>
        </div>
        <div class="sharp-card p-6 border-b-4 border-violet-600" style="box-shadow: 4px 4px 0px #7c3aed;">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total SKS</p>
            <p class="text-3xl font-black text-blue-700">{{ $totalCredits }}</p>
        </div>
        <div class="sharp-card p-6 border-b-4 border-emerald-600" style="box-shadow: 4px 4px 0px #059669;">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">File Jadwal</p>
            <p class="text-3xl font-black text-emerald-700">{{ $schedules->count() }}</p>
        </div>
        <div class="sharp-card p-6 border-b-4 {{ $globalConflicts->count() > 0 ? 'border-red-600' : 'border-slate-900' }}" style="box-shadow: 4px 4px 0px {{ $globalConflicts->count() > 0 ? '#dc2626' : '#0f172a' }};">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Konflik Global</p>
            <p class="text-3xl font-black {{ $globalConflicts->count() > 0 ? 'text-red-600' : 'text-emerald-600' }}">{{ $globalConflicts->count() }}</p>
        </div>
    </div>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">

        {{-- ── LEFT: File Filter Sidebar ── --}}
        <div class="xl:col-span-1 space-y-4">
            <div class="sharp-card overflow-hidden" style="box-shadow: 4px 4px 0px #0f172a;">
                <div class="px-6 py-4 bg-slate-900 border-b-2 border-slate-900">
                    <h2 class="text-[10px] font-black uppercase tracking-widest text-white">File Jadwal Aktif</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($schedules as $s)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <p class="text-[10px] font-black uppercase truncate text-slate-900 flex-1">{{ $s->student_name ?? basename($s->file_path) }}</p>
                            <span class="text-[8px] font-black uppercase bg-slate-900 text-white px-1.5 py-0.5 shrink-0">{{ $s->status }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[9px] font-bold text-blue-600 uppercase">{{ $s->courses->count() }} MK</span>
                            <span class="text-slate-200">|</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $s->courses->sum('credits') }} SKS</span>
                        </div>
                        <div class="mt-3 flex gap-1">
                            <a href="{{ route('student.schedule.show', $s) }}" class="flex-1 text-center text-[8px] font-black uppercase bg-slate-100 hover:bg-slate-900 hover:text-white py-1.5 transition-colors">
                                Buka
                            </a>
                            <a href="{{ route('student.course.create', $s) }}" class="flex-1 text-center text-[8px] font-black uppercase bg-blue-600 text-white hover:bg-slate-900 py-1.5 transition-colors">
                                + Tambah MK
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center opacity-40">
                        <p class="text-[10px] font-black uppercase tracking-widest">Belum Ada Jadwal</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Quick Upload --}}
            <a href="{{ route('student.upload') }}" class="block sharp-card p-5 bg-blue-600 border-blue-700 text-center hover:bg-slate-900 transition-colors group" style="box-shadow: 4px 4px 0px #1e3a8a;">
                <svg class="w-6 h-6 text-white mx-auto mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <p class="text-[10px] font-black uppercase tracking-widest text-white">Upload Jadwal Baru</p>
            </a>
        </div>

        {{-- ── RIGHT: Course Table by Day ── --}}
        <div class="xl:col-span-3">

            @if($allCourses->isEmpty())
                <div class="sharp-card p-20 text-center opacity-40" style="box-shadow: 4px 4px 0px #e2e8f0;">
                    <svg class="w-14 h-14 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-[11px] font-black uppercase tracking-widest mb-2">Belum Ada Mata Kuliah</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Upload jadwal kuliah untuk mulai menganalisis.</p>
                </div>
            @else

                @php
                    $dayColors = [
                        'SENIN'  => ['border' => 'border-blue-600',    'text' => 'text-blue-700',    'bg' => 'bg-blue-600',    'light' => 'bg-blue-50'],
                        'SELASA' => ['border' => 'border-violet-600',  'text' => 'text-violet-700',  'bg' => 'bg-violet-600',  'light' => 'bg-violet-50'],
                        'RABU'   => ['border' => 'border-sky-600',     'text' => 'text-sky-700',     'bg' => 'bg-sky-600',     'light' => 'bg-sky-50'],
                        'KAMIS'  => ['border' => 'border-emerald-600', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-600', 'light' => 'bg-emerald-50'],
                        'JUMAT'  => ['border' => 'border-amber-600',   'text' => 'text-amber-700',   'bg' => 'bg-amber-600',   'light' => 'bg-amber-50'],
                        'SABTU'  => ['border' => 'border-rose-600',    'text' => 'text-rose-700',    'bg' => 'bg-rose-600',    'light' => 'bg-rose-50'],
                        'MINGGU' => ['border' => 'border-slate-600',   'text' => 'text-slate-700',   'bg' => 'bg-slate-600',   'light' => 'bg-slate-50'],
                    ];
                @endphp

                <div class="space-y-8">
                    @foreach($grouped as $day => $courses)
                        @php $c = $dayColors[$day] ?? $dayColors['SENIN']; @endphp

                        <div class="sharp-card overflow-hidden" style="box-shadow: 4px 4px 0px #e2e8f0;">
                            {{-- Day Header --}}
                            <div class="flex items-center gap-4 px-6 py-4 {{ $c['light'] }} border-b-2 {{ $c['border'] }}">
                                <div class="w-2 h-6 {{ $c['bg'] }}"></div>
                                <h2 class="text-sm font-black uppercase tracking-[0.2em] {{ $c['text'] }}">{{ $day }}</h2>
                                <div class="flex-1 h-px bg-slate-200"></div>
                                <span class="text-[9px] font-black uppercase tracking-widest bg-slate-900 text-white px-3 py-1">
                                    {{ $courses->count() }} MK &nbsp;•&nbsp; {{ $courses->sum('credits') }} SKS
                                </span>
                            </div>

                            {{-- Course Table --}}
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b border-slate-100 bg-slate-50">
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">Waktu</th>
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">Mata Kuliah</th>
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">Kode</th>
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">SKS</th>
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">Dosen</th>
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">Ruang</th>
                                            <th class="px-5 py-3 text-[9px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($courses as $course)
                                            @php
                                                $isConflicting = $globalConflicts->contains(function($cf) use ($course) {
                                                    return ($cf['item1']->id === $course->id && get_class($cf['item1']) === get_class($course))
                                                        || ($cf['item2']->id === $course->id && get_class($cf['item2']) === get_class($course));
                                                });
                                                $fromSchedule = $course->schedule;
                                            @endphp
                                            <tr class="hover:bg-slate-50 transition-colors {{ $isConflicting ? 'bg-red-50 border-l-4 border-red-600' : '' }}">
                                                <td class="px-5 py-4">
                                                    <span class="text-[10px] font-black uppercase {{ $isConflicting ? 'text-red-600' : 'text-slate-700' }}">
                                                        {{ $course->time_start }}–{{ $course->time_end }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-2">
                                                        @if($isConflicting)
                                                            <span class="text-[8px] font-black bg-red-600 text-white px-1.5 py-0.5 uppercase shrink-0">KONFLIK</span>
                                                        @endif
                                                        <span class="text-[11px] font-black uppercase text-slate-900">{{ $course->name }}</span>
                                                    </div>
                                                    @if($fromSchedule)
                                                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-0.5">📄 {{ $fromSchedule->student_name ?? basename($fromSchedule->file_path) }}</p>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase border border-slate-200 px-1.5 py-0.5">{{ $course->code ?? '—' }}</span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="text-[11px] font-black text-blue-600 uppercase">{{ $course->credits }}</span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase truncate block max-w-[140px]">{{ $course->lecturer ?? '—' }}</span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="text-[10px] font-black text-slate-900 uppercase border-b-2 border-slate-900">{{ $course->room ?? '—' }}</span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-1">
                                                        @if($fromSchedule)
                                                            <a href="{{ route('student.course.edit', [$fromSchedule, $course]) }}"
                                                               class="w-7 h-7 border border-slate-200 flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-colors text-slate-400"
                                                               title="Edit">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                            <form action="{{ route('student.course.destroy', [$fromSchedule, $course]) }}" method="POST"
                                                                  x-data @submit.prevent="if(confirm('Hapus {{ addslashes($course->name) }}?')) $el.submit()">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                        class="w-7 h-7 border border-slate-200 flex items-center justify-center hover:bg-red-600 hover:border-red-600 hover:text-white transition-colors text-slate-400"
                                                                        title="Hapus">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
