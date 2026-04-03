<x-app-layout title="Edit Informasi Jadwal">

    <a href="{{ route('student.schedule.show', $schedule) }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 mb-6 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Detail Jadwal
    </a>

    <div class="max-w-xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-slate-100 dark:border-slate-700">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-white">Edit Informasi Jadwal</h2>
                    <p class="text-blue-200 text-xs">Perbarui data identitas mahasiswa pada jadwal ini</p>
                </div>
            </div>

            <form action="{{ route('student.schedule.update', $schedule) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div class="sm:col-span-2">
                        <label for="student_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nama Mahasiswa</label>
                        <input id="student_name" name="student_name" type="text"
                               value="{{ old('student_name', $schedule->student_name) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Nama lengkap">
                    </div>

                    <div>
                        <label for="nim" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">NIM/NPM</label>
                        <input id="nim" name="nim" type="text"
                               value="{{ old('nim', $schedule->nim) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono"
                               placeholder="13020230049">
                    </div>

                    <div>
                        <label for="semester" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Semester</label>
                        <input id="semester" name="semester" type="text"
                               value="{{ old('semester', $schedule->semester) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="2025-2026 / Genap">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="program" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Program Studi</label>
                        <input id="program" name="program" type="text"
                               value="{{ old('program', $schedule->program) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Teknik Informatika (S1)">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="advisor" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Dosen Wali</label>
                        <input id="advisor" name="advisor" type="text"
                               value="{{ old('advisor', $schedule->advisor) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Nama dosen wali">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="period" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Periode Jadwal</label>
                        <input id="period" name="period" type="text"
                               value="{{ old('period', $schedule->period) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="02 Maret 2026 – 13 Juni 2026">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-3 rounded-xl transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('student.schedule.show', $schedule) }}"
                       class="px-5 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
