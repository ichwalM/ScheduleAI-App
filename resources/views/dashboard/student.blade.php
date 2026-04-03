<x-app-layout title="Dashboard Mahasiswa">

    @php $hasSchedule = !is_null($schedule); @endphp

    {{-- ═══ BANNER ═══ --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-2xl p-6 mb-6 shadow-lg">
        <div class="absolute -top-6 -right-6 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-8 -left-4 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-blue-200 text-sm font-medium mb-0.5">Selamat datang,</p>
                <h1 class="text-white text-2xl font-bold">{{ auth()->user()->name }}</h1>
                <p class="text-blue-200 text-sm mt-1">
                    @if(!$hasSchedule)
                        Unggah jadwal kuliah untuk mendapatkan analisis AI otomatis.
                    @elseif($schedule->status === 'analyzed')
                        Jadwalmu sudah dianalisis — lihat hasilnya di bawah.
                    @elseif($schedule->status === 'failed')
                        Analisis jadwamu gagal. Hapus dan unggah ulang.
                    @else
                        Jadwalmu sedang dalam antrian analisis.
                    @endif
                </p>
            </div>
            @if(!$hasSchedule)
                <a href="{{ route('student.upload') }}"
                   class="shrink-0 inline-flex items-center gap-2 bg-white text-blue-700 font-bold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-50 transition-colors shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Unggah Jadwal
                </a>
            @endif
        </div>
    </div>

    {{-- ═══ DISCLAIMER ═══ --}}
    <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl px-5 py-4 mb-6">
        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <div>
            <p class="text-sm font-bold text-amber-800 dark:text-amber-300 mb-0.5">Perhatian — 1 Jadwal per Mahasiswa</p>
            <p class="text-sm text-amber-700 dark:text-amber-400 leading-relaxed">
                Setiap mahasiswa hanya dapat memiliki <strong>satu jadwal aktif</strong> pada satu waktu.
                Untuk mengunggah jadwal baru (baik karena gagal maupun ingin memperbarui), kamu <strong>harus menghapus jadwal yang ada terlebih dahulu</strong>, kemudian unggah ulang.
            </p>
        </div>
    </div>

    {{-- ═══ SCHEDULE CARD ═══ --}}
    @if(!$hasSchedule)
        {{-- Empty state --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-16 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </div>
            <h3 class="font-bold text-slate-700 dark:text-slate-200 mb-2 text-lg">Belum Ada Jadwal</h3>
            <p class="text-slate-400 text-sm mb-6 max-w-sm">Unggah file jadwal kuliah (PDF atau gambar) untuk mendapatkan analisis konflik dan rekomendasi dari AI.</p>
            <a href="{{ route('student.upload') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Unggah Jadwal Sekarang
            </a>
        </div>

    @else
        {{-- Schedule card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">

            {{-- Card header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-800 dark:text-white text-base">Jadwal Aktif</h2>
                        <p class="text-xs text-slate-400">Diunggah {{ $schedule->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- Status badge --}}
                @if($schedule->status === 'analyzed')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Dianalisis
                    </span>
                @elseif($schedule->status === 'pending')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span> Diproses
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Gagal
                    </span>
                @endif
            </div>

            <div class="p-6">
                {{-- Student info summary --}}
                @if($schedule->student_name || $schedule->nim)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                        @if($schedule->student_name)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Nama</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $schedule->student_name }}</p>
                            </div>
                        @endif
                        @if($schedule->nim)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">NIM</p>
                                <p class="text-sm font-mono font-semibold text-slate-800 dark:text-white">{{ $schedule->nim }}</p>
                            </div>
                        @endif
                        @if($schedule->program)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Program Studi</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ $schedule->program }}</p>
                            </div>
                        @endif
                        @if($schedule->semester)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Semester</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $schedule->semester }}</p>
                            </div>
                        @endif
                        @if($schedule->total_credits)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Total SKS</p>
                                <p class="text-sm font-bold text-blue-600">{{ $schedule->total_credits }} SKS</p>
                            </div>
                        @endif
                        @if($schedule->status === 'analyzed')
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Konflik</p>
                                @if($schedule->conflict_count > 0)
                                    <p class="text-sm font-bold text-red-600">{{ $schedule->conflict_count }} konflik ditemukan</p>
                                @else
                                    <p class="text-sm font-bold text-emerald-600">Bebas konflik ✓</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Action buttons --}}
                <div class="flex flex-wrap gap-3">
                    @if($schedule->status === 'analyzed')
                        <a href="{{ route('student.schedule.show', $schedule) }}"
                           class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Detail Jadwal
                        </a>
                        <a href="{{ route('student.schedule.edit', $schedule) }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Info
                        </a>
                    @endif

                    {{-- Delete always visible --}}
                    <form action="{{ route('student.schedule.destroy', $schedule) }}" method="POST"
                          x-data @submit.prevent="if(confirm('Hapus jadwal ini secara permanen? Kamu perlu mengunggah ulang setelahnya.')) $el.submit()"
                          class="inline-flex">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 text-sm font-medium text-red-600 border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 px-4 py-2.5 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Jadwal
                        </button>
                    </form>

                    @if($schedule->status === 'failed')
                        <p class="w-full text-xs text-red-500 mt-1">
                            ⚠ Analisis gagal. Hapus jadwal ini, lalu unggah ulang file jadwalmu.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
