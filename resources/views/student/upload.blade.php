<x-app-layout title="Unggah Jadwal">

    <div class="max-w-2xl mx-auto">

        <a href="{{ route('student.dashboard') }}"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 mb-6 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Dashboard
        </a>

        {{-- Disclaimer --}}
        <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl px-5 py-4 mb-5">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-amber-800 dark:text-amber-300 mb-0.5">Penting — 1 Jadwal per Akun</p>
                <ul class="text-sm text-amber-700 dark:text-amber-400 space-y-0.5 list-disc list-inside">
                    <li>Setiap akun hanya dapat memiliki <strong>satu jadwal aktif</strong>.</li>
                    <li>Jika analisis <strong>berhasil</strong> dan ingin memperbarui: hapus dulu, lalu unggah ulang.</li>
                    <li>Jika analisis <strong>gagal</strong>: hapus dulu, lalu unggah ulang.</li>
                    <li>Proses analisis AI memakan waktu ≤ 30 detik — harap bersabar.</li>
                </ul>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Unggah Jadwal Kuliah</h1>
                        <p class="text-blue-200 text-sm">AI akan menganalisis konflik dan memberi rekomendasi</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('student.upload.store') }}" method="POST" enctype="multipart/form-data"
                      x-data="{
                          dragging: false,
                          file: null,
                          filePreview: null,
                          loading: false,
                          handleDrop(e) {
                              this.dragging = false;
                              const f = e.dataTransfer.files[0];
                              if (f) this.setFile(f);
                          },
                          handleInput(e) {
                              const f = e.target.files[0];
                              if (f) this.setFile(f);
                          },
                          setFile(f) {
                              this.file = f;
                              if (f.type.startsWith('image/')) {
                                  const reader = new FileReader();
                                  reader.onload = (ev) => this.filePreview = ev.target.result;
                                  reader.readAsDataURL(f);
                              } else {
                                  this.filePreview = null;
                              }
                          }
                      }"
                      @submit="loading = true">
                    @csrf

                    {{-- Drop zone --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">File Jadwal</label>

                        <div @dragover.prevent="dragging = true"
                             @dragleave="dragging = false"
                             @drop.prevent="handleDrop($event)"
                             @click="$refs.fileInput.click()"
                             :class="dragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/30'"
                             class="border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition-all hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20">

                            <template x-if="filePreview">
                                <div class="mb-3">
                                    <img :src="filePreview" class="max-h-40 mx-auto rounded-lg object-cover shadow">
                                </div>
                            </template>

                            <template x-if="!file">
                                <div>
                                    <svg class="w-10 h-10 text-slate-300 dark:text-slate-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <p class="text-slate-500 dark:text-slate-400 font-medium">Drag & drop atau <span class="text-blue-600">pilih file</span></p>
                                    <p class="text-xs text-slate-400 mt-1">PDF, JPEG, PNG — Maksimal 10 MB</p>
                                </div>
                            </template>

                            <template x-if="file && !filePreview">
                                <div>
                                    <svg class="w-10 h-10 text-blue-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-slate-700 dark:text-slate-300 font-medium text-sm" x-text="file.name"></p>
                                    <p class="text-xs text-slate-400 mt-0.5" x-text="(file.size / 1024 / 1024).toFixed(2) + ' MB'"></p>
                                </div>
                            </template>

                            <input type="file" name="schedule_file" id="schedule_file"
                                   x-ref="fileInput"
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="hidden"
                                   @change="handleInput($event)">
                        </div>

                        @error('schedule_file')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- AI info --}}
                    <div class="flex items-start gap-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl p-4 mb-5">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Gemini AI</strong> akan membaca dokumenmu, mengekstrak semua mata kuliah, mendeteksi konflik jadwal, dan memberikan rekomendasi dalam <strong>Bahasa Indonesia</strong>.
                            Proses analisis biasanya selesai dalam ≤ 30 detik.
                        </p>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            :disabled="!file || loading"
                            :class="(!file || loading) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700 hover:shadow-lg'"
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                        <template x-if="loading">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </template>
                        <template x-if="!loading">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </template>
                        <span x-text="loading ? 'Menganalisis dengan AI...' : 'Analisis Jadwal'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
