<x-app-layout title="Edit Mata Kuliah">

    <a href="{{ route('student.schedule.show', $schedule) }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 mb-6 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Detail Jadwal
    </a>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100 dark:border-slate-700 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-white">Edit Mata Kuliah</h2>
                    <p class="text-blue-200 text-xs">Perbarui data mata kuliah pada jadwal ini</p>
                </div>
            </div>

            <form action="{{ route('student.course.update', [$schedule, $course]) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Hari --}}
                <div>
                    <label for="day" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Hari</label>
                    <select id="day" name="day"
                            class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('day') border-red-400 @enderror">
                        @foreach(['SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'] as $d)
                            <option value="{{ $d }}" @selected(old('day', $course->day) === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                    @error('day')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Grid 2 col --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Nama Mata Kuliah --}}
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nama Mata Kuliah</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $course->name) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-400 @enderror"
                               placeholder="Contoh: Sistem Kendali">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Kode MK --}}
                    <div>
                        <label for="code" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Kode MK</label>
                        <input id="code" name="code" type="text" value="{{ old('code', $course->code) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="1302KKA606">
                        @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="class" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Kelas</label>
                        <input id="class" name="class" type="text" value="{{ old('class', $course->class) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="A2">
                        @error('class')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- SKS --}}
                    <div>
                        <label for="credits" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">SKS</label>
                        <input id="credits" name="credits" type="number" min="1" max="10" value="{{ old('credits', $course->credits) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('credits') border-red-400 @enderror">
                        @error('credits')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Ruangan --}}
                    <div>
                        <label for="room" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Ruangan</label>
                        <input id="room" name="room" type="text" value="{{ old('room', $course->room) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="TI-408">
                        @error('room')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Jam Mulai --}}
                    <div>
                        <label for="time_start" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Jam Mulai</label>
                        <input id="time_start" name="time_start" type="time" value="{{ old('time_start', $course->time_start) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('time_start') border-red-400 @enderror">
                        @error('time_start')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Jam Selesai --}}
                    <div>
                        <label for="time_end" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Jam Selesai</label>
                        <input id="time_end" name="time_end" type="time" value="{{ old('time_end', $course->time_end) }}"
                               class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('time_end') border-red-400 @enderror">
                        @error('time_end')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Dosen --}}
                <div>
                    <label for="lecturer" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Dosen Pengampu</label>
                    <input id="lecturer" name="lecturer" type="text" value="{{ old('lecturer', $course->lecturer) }}"
                           class="w-full rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Nama dosen">
                    @error('lecturer')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-3 rounded-xl transition-colors shadow-sm hover:shadow-blue-500/30 hover:shadow-md">
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
