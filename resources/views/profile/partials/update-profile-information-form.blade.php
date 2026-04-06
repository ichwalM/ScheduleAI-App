<section>
    <header class="mb-8">
        <p class="mt-1 text-xs text-slate-500 font-bold uppercase tracking-widest">
            Perbarui informasi profil, alamat email, dan identitas tambahan akunmu.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        @php
            $profile = $user->profile ?? new \App\Models\UserProfile();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b-2 border-slate-100">
            {{-- Nama --}}
            <div>
                <x-input-label for="name" value="Nama Lengkap" class="sharp-label" />
                <x-text-input id="name" name="name" type="text" class="sharp-input" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2 text-[10px] text-red-600 font-bold uppercase" :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" value="Email Kampus" class="sharp-label" />
                <x-text-input id="email" name="email" type="email" class="sharp-input" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2 text-[10px] text-red-600 font-bold uppercase" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3">
                        <p class="text-[10px] text-slate-800 font-bold uppercase tracking-widest bg-amber-100 p-2 border-l-4 border-amber-500">
                            Email belum diverifikasi.
                            <button form="send-verification" class="underline text-blue-600 hover:text-blue-900 ml-1">
                                Kirim ulang
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-black text-[10px] text-emerald-600 uppercase tracking-widest">
                                Link verifikasi baru telah dikirim!
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            {{-- Foto Profil --}}
            <div class="md:col-span-2 flex items-start gap-6">
                <div class="relative w-24 h-24 bg-slate-100 border-4 border-slate-900 shadow-[4px_4px_0px_#0f172a] shrink-0 overflow-hidden group">
                    @if($profile->avatar_path)
                        <img src="{{ Storage::url($profile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-3xl font-black text-slate-300">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center pointer-events-none transition-all">
                        <span class="text-white text-[8px] font-black uppercase tracking-widest">Ganti Foto</span>
                    </div>
                </div>
                <div class="flex-1">
                    <x-input-label for="avatar" value="Foto Profil (Opsional)" class="sharp-label" />
                    <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg" class="mt-1 block w-full text-xs font-bold text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-2 file:border-slate-900 file:text-[10px] file:font-black file:uppercase file:bg-slate-100 file:text-slate-900 hover:file:bg-slate-900 hover:file:text-white transition-all cursor-pointer">
                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-2">Format: JPG, JPEG, PNG. Maks: 2MB.</p>
                    <x-input-error class="mt-2 text-[10px] text-red-600 font-bold uppercase" :messages="$errors->get('avatar')" />
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <x-input-label for="phone_number" value="Nomor Telepon/WA" class="sharp-label" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="sharp-input" :value="old('phone_number', $profile->phone_number)" placeholder="081xxx..." />
                <x-input-error class="mt-2 text-[10px] text-red-600 font-bold uppercase" :messages="$errors->get('phone_number')" />
            </div>

            {{-- Info Kampus / Bio --}}
            <div class="md:col-span-2">
                <x-input-label for="bio" value="Bio Singkat (Ditampilkan pada profil publik)" class="sharp-label" />
                <textarea id="bio" name="bio" rows="3" class="sharp-input resize-none" placeholder="Mahasiswa Teknik Informatika...">{{ old('bio', $profile->bio) }}</textarea>
                <x-input-error class="mt-2 text-[10px] text-red-600 font-bold uppercase" :messages="$errors->get('bio')" />
            </div>
        </div>

        {{-- Section Toggles Settings --}}
        <div class="mt-8 pt-8 border-t-2 border-slate-900">
            <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-6">Pengaturan Notifikasi Sistem</h3>
            
            <div class="flex items-center justify-between p-4 border-2 border-slate-200 bg-slate-50">
                <div>
                    <h4 class="text-xs font-black uppercase text-slate-900 mb-1">Pengingat Jadwal Harian</h4>
                    <p class="text-[10px] font-bold uppercase text-slate-500 tracking-wide">Kirim alarm jadwal via email setiap jam 06:00 pagi (WITA).</p>
                </div>
                
                {{-- Toggle Switch --}}
                <div class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                    <input type="hidden" name="daily_reminder_enabled" value="0">
                    <input type="checkbox" name="daily_reminder_enabled" id="daily_reminder_enabled" value="1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300 z-10 transition-all checked:right-0 checked:border-blue-600"
                        {{ old('daily_reminder_enabled', $profile->daily_reminder_enabled) ? 'checked' : '' }}/>
                    <label for="daily_reminder_enabled" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors"></label>
                </div>
            </div>
            <x-input-error class="mt-2 text-[10px] text-red-600 font-bold uppercase" :messages="$errors->get('daily_reminder_enabled')" />

        </div>

        <div class="flex items-center gap-4 pt-6">
            <button type="submit" class="sharp-btn">
                Simpan Perubahan Profile
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="inline-block bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 border border-emerald-300"
                >
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>
