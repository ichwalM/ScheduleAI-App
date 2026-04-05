<x-app-layout title="Manajemen Jadwal Pekerjaan">

    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-4 border-slate-900 pb-8">
            <div>
                <p class="text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Internal Terminal // Job Management</p>
                <h1 class="text-5xl font-black uppercase tracking-tighter leading-none">Manajemen Jadwal</h1>
            </div>
            <a href="{{ route('student.activities.create') }}" 
               class="bg-blue-600 text-white font-black uppercase text-[10px] tracking-widest px-8 py-4 hover:bg-slate-900 transition-colors">
                Tambah Kegiatan (+)
            </a>
        </div>
    </div>

    @if($activities->isEmpty())
        <div class="border-2 border-dashed border-slate-300 py-24 flex flex-col items-center justify-center grayscale opacity-50">
            <svg class="w-16 h-16 text-slate-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <p class="text-[10px] font-black uppercase tracking-[0.3em]">No External Load Detected</p>
            <p class="text-xs font-bold text-slate-400 mt-2 uppercase">Tambahkan jadwal kerja atau freelance kamu di sini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($activities as $activity)
                <div class="border-2 border-slate-900 bg-white p-6 flex flex-col justify-between" style="box-shadow: 6px 6px 0px #1e40af;">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[9px] font-black bg-slate-900 text-white px-2 py-0.5 uppercase tracking-widest">{{ $activity->type }}</span>
                            <span class="w-2 h-2 bg-blue-600"></span>
                        </div>
                        <h3 class="text-lg font-black uppercase tracking-tight mb-2 leading-tight">
                            {{ $activity->title }}
                        </h3>
                        <div class="space-y-1 mb-6">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $activity->day }} | {{ $activity->time_start }} - {{ $activity->time_end }}
                            </p>
                            @if($activity->location)
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $activity->location }}
                                </p>
                            @endif
                        </div>
                        @if($activity->description)
                            <p class="text-xs text-slate-600 font-medium border-t border-slate-100 pt-3 mb-6">
                                {{ $activity->description }}
                            </p>
                        @endif
                    </div>

                    <div class="flex gap-2 border-t-2 border-slate-900 pt-4 mt-auto">
                        <a href="{{ route('student.activities.edit', $activity) }}" 
                           class="flex-1 text-center py-2 text-[9px] font-black uppercase tracking-widest border border-slate-900 hover:bg-slate-50 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('student.activities.destroy', $activity) }}" method="POST" class="flex-1" x-data @submit.prevent="if(confirm('Hapus kegiatan ini?')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-center py-2 text-[9px] font-black uppercase tracking-widest border border-red-600 text-red-600 hover:bg-red-50 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>
