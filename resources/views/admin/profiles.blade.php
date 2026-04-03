<x-app-layout title="Profil Mahasiswa — Dokumentasi">

    {{-- Editorial Style Overrides --}}
    <style>
        .sharp-card { border-radius: 0 !important; border: 2px solid #000; box-shadow: 4px 4px 0px #1e40af; }
        .sharp-btn { border-radius: 0 !important; }
        .bg-doc { background-image: url("{{ asset('images/doc_campus.jpg') }}"); background-size: cover; background-position: center; }
    </style>

    {{-- Hero Documentation Header --}}
    <div class="relative w-full h-48 bg-slate-900 overflow-hidden mb-12 border-b-4 border-blue-600">
        <div class="absolute inset-0 opacity-40 bg-doc"></div>
        <div class="relative z-10 h-full flex flex-col justify-center px-8 border-l-8 border-white">
            <h1 class="text-5xl font-black text-white uppercase tracking-tighter leading-none">
                ACADEMIC<br>PROFILE HUB.
            </h1>
            <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mt-2">Monitoring & Dokumentasi Sistem Jadwal</p>
        </div>
    </div>

    {{-- Stats row — Sharp style --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-0 mb-12 border-2 border-slate-900 bg-slate-900">
        @php
            $totalAnalyzed = $students->sum(fn($s) => $s->schedules->count());
            $withSchedules = $students->filter(fn($s) => $s->schedules_count > 0)->count();
        @endphp
        <div class="bg-white p-6 border-r-2 border-slate-900">
            <p class="text-3xl font-black text-slate-900 leading-none mb-1">{{ $students->count() }}</p>
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Total Mahasiswa</p>
        </div>
        <div class="bg-white p-6 border-r-2 border-slate-900">
            <p class="text-3xl font-black text-blue-600 leading-none mb-1">{{ $withSchedules }}</p>
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Sudah Upload</p>
        </div>
        <div class="bg-white p-6 border-r-2 border-slate-900">
            <p class="text-3xl font-black text-slate-400 leading-none mb-1">{{ $students->count() - $withSchedules }}</p>
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Belum Upload</p>
        </div>
        <div class="bg-white p-6">
            <p class="text-3xl font-black text-emerald-600 leading-none mb-1">{{ $totalAnalyzed }}</p>
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Jadwal Dianalisis</p>
        </div>
    </div>

    {{-- Main Section --}}
    <div class="flex flex-col md:flex-row gap-12">
        
        {{-- List Mahasiswa --}}
        <div class="flex-grow">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black uppercase tracking-tight">Daftar Akun Mahasiswa</h2>
                <a href="{{ route('admin.students') }}" class="text-xs font-bold uppercase blue-accent hover:underline">Kelola Mahasiswa →</a>
            </div>

            @if($students->isEmpty())
                <div class="border-2 border-dashed border-slate-300 p-20 flex flex-col items-center text-center">
                    <p class="text-slate-400 font-bold uppercase tracking-widest">Belum ada mahasiswa terdaftar</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($students as $student)
                        @php
                            $latestSchedule = $student->schedules->first();
                        @endphp

                        <div class="sharp-card bg-white p-6 flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-6">
                                    <div class="w-12 h-12 bg-slate-900 text-white flex items-center justify-center font-black text-xl">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    @if($latestSchedule)
                                        <span class="text-[10px] font-bold uppercase bg-blue-100 text-blue-800 px-2 py-1">Active</span>
                                    @else
                                        <span class="text-[10px] font-bold uppercase bg-slate-100 text-slate-400 px-2 py-1">Inactive</span>
                                    @endif
                                </div>
                                <h3 class="font-black text-lg uppercase tracking-tight mb-1 truncate">{{ $student->name }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 truncate">{{ $student->email }}</p>
                                
                                @if($latestSchedule)
                                    <div class="space-y-2 border-t-2 border-slate-100 pt-4 mb-6">
                                        <div class="flex justify-between">
                                            <span class="text-[10px] font-bold uppercase text-slate-400">NIM</span>
                                            <span class="text-[10px] font-black text-slate-800">{{ $latestSchedule->nim }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-[10px] font-bold uppercase text-slate-400">Prodi</span>
                                            <span class="text-[10px] font-black text-slate-800 truncate pl-4">{{ $latestSchedule->program }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-[10px] font-bold uppercase text-slate-400">Analysis</span>
                                            <span class="text-[10px] font-black {{ $latestSchedule->status === 'analyzed' ? 'text-emerald-600' : 'text-red-500' }} uppercase">
                                                {{ $latestSchedule->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.schedules.show', $latestSchedule) }}" 
                                       class="block w-full py-3 bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest text-center hover:bg-blue-700 transition-colors">
                                        Lihat Jadwal
                                    </a>
                                @else
                                    <div class="py-12 border-t-2 border-slate-100 flex flex-col items-center justify-center grayscale opacity-30">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                        <p class="text-[10px] font-bold uppercase">No Documentation Found</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Sidebar Documentation Photo --}}
        <div class="md:w-80 shrink-0">
            <div class="sticky top-32 space-y-8">
                <div class="border-4 border-slate-900 p-2 bg-white">
                    <img src="{{ asset('images/doc_ai.jpg') }}" alt="AI Documentation" class="w-full grayscale active:grayscale-0 transition-all">
                    <div class="mt-4 p-4 border-t-2 border-slate-900">
                        <p class="text-[10px] font-black uppercase tracking-widest leading-tight">AI Analysis Node #002</p>
                        <p class="text-[10px] font-bold text-slate-500 uppercase mt-1">Status: Operational</p>
                    </div>
                </div>
                <div class="bg-blue-600 p-6 text-white border-4 border-slate-900">
                    <h4 class="text-xl font-black uppercase tracking-tighter mb-4">Project Summary</h4>
                    <ul class="text-[10px] font-bold uppercase tracking-widest space-y-2">
                        <li class="flex justify-between"><span>Model:</span> <span>Gemini v1.5</span></li>
                        <li class="flex justify-between"><span>Normalization:</span> <span>Strict</span></li>
                        <li class="flex justify-between"><span>Lang:</span> <span>Indonesian</span></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
