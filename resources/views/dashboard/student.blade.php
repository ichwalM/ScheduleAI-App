<x-app-layout title="Dashboard Mahasiswa">

    @php 
        $hasSchedule = $schedules->isNotEmpty(); 
        $latest = $latestSchedule;
        $conflictCount = $globalConflicts->count();
    @endphp

    <style>
        .sharp-card { border-radius: 0 !important; border: 2px solid #000; box-shadow: 4px 4px 0px #1e40af; background: #fff; }
        .sharp-btn { border-radius: 0 !important; }
        .bg-doc-student { background-image: url("{{ asset('images/doc_student.jpg') }}"); background-size: cover; background-position: center; }
        .conflict-glow { box-shadow: 4px 4px 0px #dc2626 !important; border-color: #dc2626 !important; }
    </style>

    {{-- ═══ HERO DOCUMENTATION ═══ --}}
    <div class="relative w-full h-40 bg-slate-900 overflow-hidden mb-8 border-b-4 border-blue-600">
        <div class="absolute inset-0 opacity-30 bg-doc-student"></div>
        <div class="relative z-10 h-full flex flex-col justify-center px-10 border-l-8 border-white">
            <p class="text-blue-300 text-[10px] font-bold uppercase tracking-widest mb-1">Authenticated Student Terminal</p>
            <h1 class="text-4xl font-black text-white uppercase tracking-tighter leading-none">
                {{ auth()->user()->name }}
            </h1>
            <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest mt-2 italic">
                @if(!$hasSchedule)
                    STATUS: AWAITING UPLOAD
                @else
                    ANALYZED: {{ $schedules->count() }} SCHEDULES LOADED
                @endif
            </p>
        </div>
    </div>

    {{-- ═══ GLOBAL CONFLICT ALERT ═══ --}}
    @if($conflictCount > 0)
    <div class="flex items-center gap-4 border-4 border-red-600 bg-red-50 p-6 mb-10 animate-pulse">
        <div class="w-12 h-12 bg-red-600 flex items-center justify-center shrink-0">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-lg font-black text-red-600 uppercase tracking-tighter leading-none mb-1">CRITICAL SYSTEM OVERLAP</p>
            <p class="text-[11px] text-red-800 font-bold uppercase">Terdeteksi {{ $conflictCount }} jadwal yang bertabrakan. Cek detail jadwal untuk melihat label merah.</p>
        </div>
    </div>
    @endif

    {{-- ═══ PROTOCOL UPDATE ═══ --}}
    <div class="flex items-start gap-4 border-2 border-slate-900 bg-slate-50 p-6 mb-10">
        <svg class="w-6 h-6 text-slate-900 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-xs font-black text-slate-900 uppercase tracking-widest mb-1">Protocol: Multiple Schedule Support Alpha</p>
            <p class="text-[11px] text-slate-700 font-bold leading-relaxed uppercase">
                Kamu sekarang bisa mengunggah lebih dari satu jadwal. Sistem akan otomatis mendeteksi tabrakan waktu di semua file yang aktif.
            </p>
        </div>
    </div>

    {{-- ═══ GOOGLE CALENDAR PROTOCOL ═══ --}}
    <div class="flex items-center justify-between border-2 border-slate-900 bg-white p-6 mb-10 sharp-card">
        <div class="flex items-center gap-4">
            <svg class="w-8 h-8 {{ auth()->user()->google_token ? 'text-blue-600' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <div>
                <p class="text-xs font-black text-slate-900 uppercase tracking-widest mb-1">Google Calendar Sync</p>
                <p class="text-[11px] font-bold uppercase {{ auth()->user()->google_token ? 'text-blue-600' : 'text-slate-500' }}">
                    {{ auth()->user()->google_token ? 'STATUS: TERHUBUNG' : 'STATUS: DISCONNECTED' }}
                </p>
            </div>
        </div>
        @if(!auth()->user()->google_token)
            <a href="{{ route('google.redirect') }}" class="sharp-btn px-6 py-3 bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-colors">
                Connect Google Calendar
            </a>
        @else
            <span class="text-[10px] font-black uppercase text-slate-900 bg-blue-100 px-3 py-1">Ready to Sync</span>
        @endif
    </div>

    {{-- ═══ GRID SUMMARY ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- List of Schedules --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-black uppercase tracking-tight">Active Repositories</h2>
                <a href="{{ route('student.upload') }}" class="bg-blue-600 text-white px-4 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-colors">
                    (+) Upload New
                </a>
            </div>

            @if(!$hasSchedule)
                <div class="sharp-card p-12 flex flex-col items-center justify-center grayscale opacity-40">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <p class="text-[12px] font-black uppercase tracking-widest">Zero Data Found</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($schedules as $s)
                    <div class="sharp-card p-6 flex flex-col justify-between {{ $s->conflicts->count() > 0 ? 'conflict-glow' : '' }}">
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[9px] font-black uppercase bg-slate-900 text-white px-2 py-0.5">{{ $s->status }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $s->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h3 class="text-xs font-black uppercase truncate mb-1">{{ $s->student_name ?? 'Unnamed Schedule' }}</h3>
                            <p class="text-[10px] font-bold text-blue-600 uppercase">{{ $s->nim ?? 'Generic' }} • {{ $s->courses->count() }} MK</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('student.schedule.show', $s) }}" class="flex-1 bg-slate-100 text-slate-900 text-center py-2 text-[9px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-colors">
                                Open Terminal
                            </a>
                            <form action="{{ route('student.schedule.destroy', $s) }}" method="POST" x-data @submit.prevent="if(confirm('Purge this file?')) $el.submit()">
                                @csrf @method('DELETE')
                                <button type="submit" class="border border-red-600 text-red-600 px-3 py-2 text-[9px] font-black uppercase hover:bg-red-50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Global Stats & External --}}
        <div class="space-y-6">
            <div class="sharp-card p-8 bg-slate-900 text-white" style="box-shadow: 4px 4px 0px #1e40af;">
                <h2 class="text-lg font-black uppercase tracking-tight mb-6">Master Stats</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-white/40 uppercase">Total Items Active</p>
                        <p class="text-2xl font-black uppercase">{{ $allItems->count() }} Entries</p>
                    </div>
                    <div class="pt-4 border-t border-white/10">
                        <p class="text-[10px] font-bold text-white/40 uppercase">Global Overlaps</p>
                        <p class="text-2xl font-black uppercase {{ $conflictCount > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $conflictCount }} Events
                        </p>
                    </div>
                </div>
            </div>

            <div class="sharp-card p-8 flex flex-col justify-between" style="box-shadow: 4px 4px 0px #000;">
                <div>
                    <h2 class="text-xl font-black uppercase tracking-tight mb-8">Quick Jobs</h2>
                    
                    @php
                        $activities = auth()->user()->allActivities()->latest()->take(5)->get();
                    @endphp

                    @if($activities->isEmpty())
                        <div class="py-12 flex flex-col items-center justify-center grayscale opacity-40">
                            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <p class="text-[10px] font-black uppercase tracking-widest">No Jobs Found</p>
                        </div>
                    @else
                        <div class="space-y-4 mb-8">
                            @foreach($activities as $activity)
                                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-black uppercase truncate">{{ $activity->title }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase italic">{{ $activity->day }} ({{ $activity->time_start }})</p>
                                    </div>
                                    <span class="w-2 h-2 bg-blue-600 shrink-0"></span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('student.activities.index') }}" class="w-full border-2 border-slate-900 text-slate-900 text-center py-4 text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-colors">
                        Terminal Manage
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
