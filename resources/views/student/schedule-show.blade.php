<x-app-layout title="Analisis Jadwal Terminal">

    <style>
        .sharp-card { border-radius: 0 !important; border: 2px solid #000; background: #fff; }
        .bg-doc-campus { background-image: url("{{ asset('images/doc_campus.jpg') }}"); background-size: cover; background-position: center; }
    </style>

    {{-- ─── Back link ─── --}}
    <a href="{{ route('student.dashboard') }}"
       class="inline-flex items-center gap-1.5 text-[10px] text-slate-500 hover:text-blue-600 mb-6 font-black uppercase tracking-widest transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        Return to Terminal
    </a>

    @if($schedule->status === 'analyzed')

        @php
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

            // Load Master Data
            $allItems = auth()->user()->getAllItems();
            $globalConflicts = auth()->user()->global_conflicts;

            $grouped = [];
            foreach ($dayOrder as $d) {
                $dayItems = $allItems->filter(fn($i) => strtoupper($i->day) === $d)->sortBy('time_start');
                if ($dayItems->isNotEmpty()) $grouped[$d] = $dayItems;
            }

            $totalCredits  = $schedule->total_credits ?: $schedule->courses->sum('credits');
            $conflictCount = $globalConflicts->count();
        @endphp

        {{-- ═══ HERO INFO ═══ --}}
        <div class="relative w-full h-48 bg-slate-900 overflow-hidden mb-10 border-b-4 border-blue-600 shadow-[8px_8px_0px_#000]">
            <div class="absolute inset-0 opacity-20 bg-doc-campus"></div>
            <div class="relative z-10 h-full flex flex-row items-center px-10 gap-10">
                <div class="w-24 h-24 bg-white border-4 border-slate-900 flex items-center justify-center text-4xl font-black shrink-0 shadow-[4px_4px_0px_#1e40af]">
                    {{ strtoupper(substr($schedule->student_name ?? auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-2">Student Intelligence Profile</p>
                    <h1 class="text-4xl font-black text-white uppercase tracking-tighter leading-none mb-1">
                        {{ $schedule->student_name ?? auth()->user()->name }}
                    </h1>
                    <div class="flex flex-wrap gap-x-6 gap-y-1 mt-3">
                        <p class="text-white font-bold text-xs uppercase tracking-widest border-r border-white/20 pr-6">{{ $schedule->nim }}</p>
                        <p class="text-white/60 font-bold text-xs uppercase tracking-widest">{{ $schedule->program }}</p>
                    </div>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-white/40 text-[10px] font-black uppercase tracking-widest">Master System Health</p>
                    <p class="text-2xl font-black {{ $conflictCount > 0 ? 'text-red-500' : 'text-emerald-500' }} uppercase">
                        {{ $conflictCount > 0 ? 'COMPROMISED' : 'OPTIMAL' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ═══ SUMMARY STATS (Master View) ═══ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="sharp-card p-6 border-b-4 border-blue-600">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Academic Load</p>
                <p class="text-3xl font-black uppercase tracking-tighter">{{ auth()->user()->allCourses->sum('credits') }} SKS</p>
            </div>
            <div class="sharp-card p-6 border-b-4 border-violet-600">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total MK Entries</p>
                <p class="text-3xl font-black uppercase tracking-tighter">{{ auth()->user()->allCourses->count() }} MK</p>
            </div>
            <div class="sharp-card p-6 border-b-4 border-emerald-600">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Master Agenda</p>
                <p class="text-3xl font-black uppercase tracking-tighter">{{ auth()->user()->allActivities->count() }} JOBS</p>
            </div>
            <div class="sharp-card p-6 border-b-4 {{ $conflictCount > 0 ? 'border-red-600' : 'border-emerald-600' }}">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Global Conflicts</p>
                <p class="text-3xl font-black uppercase tracking-tighter {{ $conflictCount > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                    {{ $conflictCount }} Events
                </p>
            </div>
        </div>

    {{-- ═══ JADWAL MINGGUAN (MASTER TIMELINE) ═══ --}}
    <div class="sharp-card mb-10 overflow-hidden">
        <div class="flex items-center gap-3 px-8 py-6 border-b-2 border-slate-900 bg-slate-50">
            <h2 class="text-xl font-black uppercase tracking-tight">Master Weekly Timeline</h2>
            <div class="ml-auto flex items-center gap-4">
                <a href="{{ route('student.course.create', $schedule) }}"
                   class="inline-flex items-center gap-2 text-[10px] font-black text-white bg-blue-600 hover:bg-slate-900 px-4 py-2 transition-colors uppercase tracking-widest">
                    (+) Add Course
                </a>
                <a href="{{ route('student.activities.create') }}"
                   class="inline-flex items-center gap-2 text-[10px] font-black text-white bg-emerald-600 hover:bg-slate-900 px-4 py-2 transition-colors uppercase tracking-widest">
                    (+) Add Job
                </a>
            </div>
        </div>

        <div class="p-8 space-y-10">
            @foreach($grouped as $day => $items)
                @php $c = $dayColors[$day] ?? $dayColors['SENIN']; @endphp
                <div>
                    <div class="flex items-center gap-4 mb-6">
                        <h3 class="text-lg font-black uppercase tracking-[0.2em] {{ $c['text'] }}">{{ $day }}</h3>
                        <div class="flex-1 h-0.5 bg-slate-100"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest bg-slate-900 text-white px-3 py-1">{{ $items->count() }} Master Entries</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($items as $item)
                            @php
                                $itemSchedule = $item->schedule;
                                $isCurrentFile = $itemSchedule && $itemSchedule->id === $schedule->id;
                                $isConflicting = $globalConflicts->contains(function($cf) use ($item) {
                                    return ($cf['item1']->id === $item->id && get_class($cf['item1']) === get_class($item))
                                        || ($cf['item2']->id === $item->id && get_class($cf['item2']) === get_class($item));
                                });
                            @endphp
                            
                            @if(!$item->is_activity)
                                {{-- Course Card --}}
                                <div class="sharp-card p-5 border-l-8 {{ $isConflicting ? 'border-red-600' : ($isCurrentFile ? $c['border'] : 'border-slate-300') }} hover:bg-slate-50 transition-colors group relative">
                                    @if($isConflicting)
                                        <div class="absolute -top-3 -right-3 bg-red-600 text-white text-[8px] font-black px-2 py-1 shadow-[2px_2px_0px_#000] uppercase tracking-widest z-10">KONFLIK</div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 {{ $isConflicting ? 'bg-red-50 text-red-600' : 'bg-slate-100' }}">
                                            {{ $item->time_start }} – {{ $item->time_end }}
                                        </span>
                                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @if($itemSchedule && $itemSchedule->user_id === auth()->id())
                                                <a href="{{ route('student.course.edit', [$itemSchedule, $item]) }}" class="text-slate-400 hover:text-blue-600 px-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                            @endif
                                        </div>
                                    </div>
                                    <h4 class="text-sm font-black uppercase tracking-tight mb-2 leading-snug @if($isConflicting) text-red-600 @endif">{{ $item->name }}</h4>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest border border-slate-200 px-1.5 py-0.5">{{ $item->code }}</span>
                                        @if(!$isCurrentFile && $itemSchedule)
                                            <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest border border-blue-600 px-1.5 py-0.5">FILE: {{ substr(basename($itemSchedule->file_path), 0, 10) }}...</span>
                                        @endif
                                        <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest border border-blue-600 px-1.5 py-0.5">{{ $item->credits }} SKS</span>
                                    </div>
                                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest truncate max-w-[120px]">{{ $item->lecturer }}</p>
                                        <p class="text-[10px] font-black text-slate-900 border-b-2 border-slate-900">{{ $item->room }}</p>
                                    </div>
                                </div>
                            @else
                                {{-- Activity Card (Job/Freelance) --}}
                                <div class="sharp-card p-5 border-l-8 {{ $isConflicting ? 'border-red-600' : 'border-slate-900' }} bg-slate-900 text-white group relative">
                                    @if($isConflicting)
                                        <div class="absolute -top-3 -right-3 bg-red-600 text-white text-[8px] font-black px-2 py-1 shadow-[2px_2px_0px_#000] uppercase tracking-widest z-10">KONFLIK</div>
                                    @endif

                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 bg-white/10 text-blue-400">
                                            {{ $item->time_start }} – {{ $item->time_end }}
                                        </span>
                                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('student.activities.edit', $item) }}" class="text-slate-400 hover:text-white px-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                        </div>
                                    </div>
                                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] mb-1">EXTERNAL: {{ $item->type }}</p>
                                    <h4 class="text-sm font-black uppercase tracking-tight mb-4 leading-snug @if($isConflicting) text-red-500 @endif">{{ $item->title }}</h4>
                                    <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                                        <p class="text-[10px] font-bold text-white/50 uppercase tracking-widest truncate">{{ $item->location ?? 'REMOTE' }}</p>
                                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-10">

        {{-- ═══ REKOMENDASI (Current File) ═══ --}}
        <div class="sharp-card overflow-hidden">
            <div class="px-8 py-6 border-b-2 border-slate-900 bg-amber-50">
                <h2 class="text-lg font-black uppercase tracking-tight text-amber-700">AI File Intelligence: {{ basename($schedule->file_path) }}</h2>
            </div>
            <div class="p-8">
                @if($schedule->recommendations->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($schedule->recommendations as $rec)
                            <div class="flex gap-4 items-start pb-4 border-b border-slate-100 last:border-0">
                                <span class="bg-slate-900 text-white text-[10px] font-black px-2 py-0.5 mt-0.5">{{ $loop->iteration }}</span>
                                <p class="text-xs font-bold text-slate-600 uppercase leading-relaxed">{{ $rec->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center opacity-40">
                        <p class="text-[10px] font-black uppercase tracking-widest">No Specific Recommendations for this File</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══ MASTER STATUS ═══ --}}
        <div class="sharp-card overflow-hidden border-blue-600">
            <div class="px-8 py-6 border-b-2 border-slate-900 bg-slate-50">
                <h2 class="text-lg font-black uppercase tracking-tight text-slate-900">Master Repository Info</h2>
            </div>
            <div class="p-8 space-y-6">
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 mb-2">Current Active Buffers</p>
                    <div class="space-y-2">
                        @foreach(auth()->user()->schedules as $s)
                            <div class="flex items-center justify-between text-[11px] font-bold uppercase p-2 border border-slate-100">
                                <span>{{ basename($s->file_path) }}</span>
                                <span class="text-blue-600">{{ $s->courses->count() }} MK</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ AKSI FILE ═══ --}}
    <div class="sharp-card p-8 bg-slate-900 text-white mb-10 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="flex items-center gap-6">
            <div class="w-12 h-12 bg-white flex items-center justify-center text-slate-900 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Active Buffer Focus</p>
                <p class="text-sm font-black uppercase truncate">{{ basename($schedule->file_path) }}</p>
            </div>
        </div>
        <div class="flex gap-4 w-full md:w-auto">
            <a href="{{ Storage::disk($schedule->file_disk)->url($schedule->file_path) }}" target="_blank"
               class="flex-1 md:flex-none bg-blue-600 text-white px-8 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-slate-900 transition-colors">
                Download Source
            </a>
            <form action="{{ route('student.schedule.destroy', $schedule) }}" method="POST" class="flex-1 md:flex-none"
                  x-data @submit.prevent="if(confirm('PURGE DATA? This action is irreversible.')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-600 text-white px-8 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-red-600 transition-colors">
                    Purge Schedule
                </button>
            </form>
        </div>
    </div>

@else
    {{-- Handle other statuses --}}
    <div class="sharp-card p-24 text-center">
        <p class="text-[10px] font-black uppercase tracking-[0.5em] mb-4">System Status: {{ strtoupper($schedule->status) }}</p>
        <h2 class="text-2xl font-black uppercase mb-8">Processing Academic Data...</h2>
        <a href="{{ route('student.dashboard') }}" class="inline-block bg-slate-900 text-white px-10 py-4 text-[10px] font-black uppercase tracking-widest">Return to Base</a>
    </div>
@endif

</x-app-layout>
