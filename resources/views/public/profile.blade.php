<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal {{ $user->name }} — ScheduleAI</title>
    <meta name="description" content="Lihat jadwal lengkap {{ $user->name }} di ScheduleAI — Sistem manajemen jadwal akademik cerdas.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; border-radius: 0 !important; }
        .bg-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 28px 28px; }
        .sharp-card { border: 2px solid #0f172a; background: #fff; }
        .conflict-label { position: absolute; top: -10px; right: -10px; background: #dc2626; color: #fff; font-size: 8px; font-weight: 900; padding: 2px 8px; letter-spacing: 0.15em; text-transform: uppercase; box-shadow: 2px 2px 0px #000; z-index: 10; }
    </style>
</head>
<body class="bg-slate-50 bg-grid min-h-screen text-slate-900 antialiased">

{{-- ═══ NAV ═══ --}}
<nav class="border-b-2 border-slate-900 bg-white sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-900 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-black text-xl tracking-tighter uppercase">ScheduleAI</span>
        </a>
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hidden sm:block">Profil Publik</span>
            <a href="{{ route('login') }}" class="bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 hover:bg-blue-600 transition-colors">
                Masuk
            </a>
        </div>
    </div>
</nav>

{{-- ═══ HERO ═══ --}}
<div class="bg-slate-900 border-b-4 border-blue-600">
    <div class="max-w-7xl mx-auto px-6 py-16 flex flex-col md:flex-row items-start md:items-end justify-between gap-8">
        <div>
            <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4">Public Schedule Terminal</p>
            <div class="flex items-center gap-6 mb-4">
                <div class="w-20 h-20 bg-blue-600 border-4 border-white flex items-center justify-center text-4xl font-black text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tighter leading-none break-words">
                        {{ $user->name }}
                    </h1>
                    @php $latestAnalyzed = $schedules->first(); @endphp
                    @if($latestAnalyzed)
                        <p class="text-white/50 text-[11px] font-bold uppercase tracking-widest mt-2">
                            {{ $latestAnalyzed->nim ?? '—' }} &nbsp;•&nbsp; {{ $latestAnalyzed->program ?? 'Program Studi' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Master Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-0 border-2 border-white/20 w-full md:w-auto">
            <div class="px-6 py-5 border-r border-b sm:border-b-0 border-white/20">
                <p class="text-xl md:text-2xl font-black text-white">{{ $schedules->count() }}</p>
                <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Jadwal Aktif</p>
            </div>
            <div class="px-6 py-5 border-b sm:border-b-0 sm:border-r border-white/20">
                <p class="text-xl md:text-2xl font-black text-white">{{ $allItems->count() }}</p>
                <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Total Entri</p>
            </div>
            <div class="px-6 py-5 col-span-2 sm:col-span-1">
                <p class="text-xl md:text-2xl font-black {{ $globalConflicts->count() > 0 ? 'text-red-400' : 'text-emerald-400' }}">
                    {{ $globalConflicts->count() }}
                </p>
                <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Konflik</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- ═══ GLOBAL CONFLICT ALERT ═══ --}}
    @if($globalConflicts->count() > 0)
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 border-4 border-red-600 bg-red-50 p-6 mb-10">
        <div class="w-12 h-12 bg-red-600 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-base font-black text-red-600 uppercase tracking-tighter leading-none mb-1">Ditemukan Tabrakan Jadwal</p>
            <p class="text-[11px] text-red-700 font-bold uppercase">{{ $globalConflicts->count() }} entri memiliki konflik waktu. Item yang tabrakan ditandai label merah di bawah.</p>
        </div>
    </div>
    @endif

    @if($schedules->isEmpty())
        {{-- Empty state --}}
        <div class="sharp-card p-24 text-center" style="box-shadow: 4px 4px 0px #1e40af;">
            <svg class="w-16 h-16 mx-auto mb-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-[12px] font-black uppercase tracking-widest text-slate-400 mb-4">Jadwal Belum Tersedia</p>
            <p class="text-[11px] font-bold text-slate-300 uppercase">Mahasiswa ini belum mengupload jadwal yang telah dianalisis.</p>
        </div>
    @else
        @php
            $dayColors = [
                'SENIN'  => ['text' => 'text-blue-900',    'border' => 'border-blue-600',    'badge' => 'bg-blue-900'],
                'SELASA' => ['text' => 'text-violet-900',  'border' => 'border-violet-600',  'badge' => 'bg-violet-900'],
                'RABU'   => ['text' => 'text-sky-900',     'border' => 'border-sky-600',     'badge' => 'bg-sky-900'],
                'KAMIS'  => ['text' => 'text-emerald-900', 'border' => 'border-emerald-600', 'badge' => 'bg-emerald-900'],
                'JUMAT'  => ['text' => 'text-amber-900',   'border' => 'border-amber-600',   'badge' => 'bg-amber-900'],
                'SABTU'  => ['text' => 'text-rose-900',    'border' => 'border-rose-600',    'badge' => 'bg-rose-900'],
                'MINGGU' => ['text' => 'text-slate-900',   'border' => 'border-slate-600',   'badge' => 'bg-slate-900'],
            ];
        @endphp

        {{-- Info note --}}
        <div class="flex items-center gap-3 border-2 border-slate-900 bg-white px-6 py-4 mb-10">
            <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-[11px] font-black uppercase tracking-widest text-slate-600">
                Master Timeline — Menampilkan semua jadwal kuliah dan kegiatan dari seluruh file yang aktif.
            </p>
        </div>

        {{-- ═══ MASTER TIMELINE ═══ --}}
        @if(empty($grouped))
            <div class="sharp-card p-16 text-center opacity-40">
                <p class="text-[10px] font-black uppercase tracking-widest">Tidak Ada Data Jadwal Ditemukan</p>
            </div>
        @else
            <div class="space-y-12">
                @foreach($grouped as $day => $items)
                    @php $c = $dayColors[$day] ?? $dayColors['SENIN']; @endphp
                    <div>
                        {{-- Day Header --}}
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-px flex-1 bg-slate-200"></div>
                            <h2 class="text-xs font-black uppercase tracking-[0.3em] {{ $c['text'] }} {{ $c['badge'] }} text-white px-4 py-1.5">
                                {{ $day }}
                            </h2>
                            <div class="h-px flex-1 bg-slate-200"></div>
                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 border border-slate-200 px-2 py-1">
                                {{ $items->count() }} Entri
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                            @foreach($items as $item)
                                @php
                                    $isConflicting = $globalConflicts->contains(function($cf) use ($item) {
                                        return ($cf['item1']->id === $item->id && get_class($cf['item1']) === get_class($item))
                                            || ($cf['item2']->id === $item->id && get_class($cf['item2']) === get_class($item));
                                    });
                                @endphp

                                @if(!$item->is_activity)
                                    {{-- Course Card --}}
                                    <div class="sharp-card p-5 border-l-4 {{ $isConflicting ? 'border-red-600' : $c['border'] }} relative" style="{{ $isConflicting ? 'box-shadow: 4px 4px 0px #dc2626;' : 'box-shadow: 4px 4px 0px #e2e8f0;' }}">
                                        @if($isConflicting)
                                            <div class="conflict-label">KONFLIK</div>
                                        @endif
                                        <div class="mb-3">
                                            <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 {{ $isConflicting ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $item->time_start }} – {{ $item->time_end }}
                                            </span>
                                        </div>
                                        <h3 class="text-[11px] font-black uppercase leading-snug mb-2 {{ $isConflicting ? 'text-red-600' : '' }}">
                                            {{ $item->name }}
                                        </h3>
                                        <div class="flex flex-wrap gap-1.5 mb-3">
                                            <span class="text-[9px] font-bold text-slate-400 border border-slate-200 px-1.5 py-0.5 uppercase">{{ $item->code }}</span>
                                            <span class="text-[9px] font-bold text-slate-600 border border-slate-300 px-1.5 py-0.5 uppercase bg-slate-50">KELAS: {{ $item->class ?? '-' }}</span>
                                            <span class="text-[9px] font-bold text-blue-600 border border-blue-200 px-1.5 py-0.5 uppercase">{{ $item->credits }} SKS</span>
                                        </div>
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase truncate">{{ $item->lecturer }}</p>
                                            <p class="text-[9px] font-black text-slate-700 uppercase shrink-0 border-b border-slate-700">{{ $item->room }}</p>
                                        </div>
                                    </div>
                                @else
                                    {{-- Activity Card --}}
                                    <div class="sharp-card p-5 border-l-4 {{ $isConflicting ? 'border-red-600' : 'border-slate-900' }} bg-slate-900 text-white relative" style="{{ $isConflicting ? 'box-shadow: 4px 4px 0px #dc2626;' : 'box-shadow: 4px 4px 0px #475569;' }}">
                                        @if($isConflicting)
                                            <div class="conflict-label">KONFLIK</div>
                                        @endif
                                        <div class="mb-3">
                                            <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 bg-white/10 text-blue-400">
                                                {{ $item->time_start }} – {{ $item->time_end }}
                                            </span>
                                        </div>
                                        <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest mb-1">{{ $item->type }}</p>
                                        <h3 class="text-[11px] font-black uppercase leading-snug mb-3 {{ $isConflicting ? 'text-red-400' : '' }}">{{ $item->title }}</h3>
                                        <div class="pt-3 border-t border-white/10">
                                            <p class="text-[9px] font-bold text-white/40 uppercase">{{ $item->location ?? 'Remote' }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ═══ JADWAL FILES ═══ --}}
        <div class="mt-16 pt-10 border-t-2 border-slate-200">
            <h2 class="text-sm font-black uppercase tracking-widest mb-6 text-slate-400">Repository Jadwal Aktif</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($schedules as $s)
                <div class="sharp-card p-5" style="box-shadow: 4px 4px 0px #e2e8f0;">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-[8px] font-black uppercase bg-slate-900 text-white px-2 py-0.5">{{ $s->status }}</span>
                        <span class="text-[8px] font-bold text-slate-400 uppercase">{{ $s->created_at->format('d/m/Y') }}</span>
                    </div>
                    <p class="text-[11px] font-black uppercase truncate mb-1">{{ $s->student_name ?? basename($s->file_path) }}</p>
                    <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-100">
                        <span class="text-[9px] font-bold text-blue-600 uppercase">{{ $s->courses->count() }} MK</span>
                        <span class="text-slate-200">|</span>
                        <span class="text-[9px] font-bold text-emerald-600 uppercase">{{ $s->activities->count() }} Kegiatan</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- ═══ FOOTER ═══ --}}
<footer class="border-t-2 border-slate-900 bg-slate-900 text-white mt-20 py-10 px-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">ScheduleAI — Halaman Publik</p>
            <p class="text-[10px] font-bold text-slate-500 uppercase mt-1">Jadwal ini ditampilkan secara publik oleh pemilik akun.</p>
        </div>
        <a href="{{ route('register') }}" class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 hover:bg-white hover:text-slate-900 transition-colors shrink-0">
            Buat Jadwal Saya →
        </a>
    </div>
</footer>

</body>
</html>
