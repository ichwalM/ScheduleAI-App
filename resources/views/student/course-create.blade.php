<x-app-layout title="Tambah Mata Kuliah">

    <a href="{{ route('student.schedule.show', $schedule) }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 mb-6 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Detail Jadwal
    </a>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-5 bg-gradient-to-r from-emerald-600 to-emerald-700">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-white">Tambah Mata Kuliah</h2>
                    <p class="text-emerald-200 text-xs">Tambahkan mata kuliah baru ke jadwal ini secara manual</p>
                </div>
            </div>

            <form action="{{ route('student.course.store', $schedule) }}" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- Hari --}}
                <div>
                    <label for="day" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Hari <span class="text-red-500">*</span></label>
                    <select id="day" name="day"
                            class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('day') border-red-400 @enderror">
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'] as $d)
                            <option value="{{ $d }}" @selected(old('day') === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                    @error('day')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nama Mata Kuliah <span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-400 @enderror"
                               placeholder="Contoh: Sistem Kendali">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Kode MK</label>
                        <input id="code" name="code" type="text" value="{{ old('code') }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono"
                               placeholder="1302KKA606">
                    </div>

                    <div>
                        <label for="class" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Kelas</label>
                        <input id="class" name="class" type="text" value="{{ old('class') }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="A2">
                    </div>

                    <div>
                        <label for="credits" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">SKS <span class="text-red-500">*</span></label>
                        <input id="credits" name="credits" type="number" min="1" max="10" value="{{ old('credits', 3) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('credits') border-red-400 @enderror">
                        @error('credits')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="room" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Ruangan</label>
                        <input id="room" name="room" type="text" value="{{ old('room') }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="TI-408">
                    </div>

                    <div>
                        <label for="time_start" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Jam Mulai <span class="text-red-500">*</span></label>
                        <input id="time_start" name="time_start" type="time" value="{{ old('time_start') }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('time_start') border-red-400 @enderror">
                        @error('time_start')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="time_end" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Jam Selesai <span class="text-red-500">*</span></label>
                        <input id="time_end" name="time_end" type="time" value="{{ old('time_end') }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('time_end') border-red-400 @enderror">
                        @error('time_end')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="lecturer" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Dosen Pengampu</label>
                    <input id="lecturer" name="lecturer" type="text" value="{{ old('lecturer') }}"
                           class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Nama dosen">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-3 rounded-xl transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Mata Kuliah
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
