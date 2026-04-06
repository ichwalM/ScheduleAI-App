<section>
    <header class="mb-6">
        <p class="mt-1 text-xs text-slate-500 font-bold uppercase tracking-widest">
            Pastikan akunmu menggunakan kata sandi panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Kata Sandi Saat Ini" class="sharp-label" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="sharp-input" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px] text-red-600 font-bold uppercase" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Kata Sandi Baru" class="sharp-label" />
            <x-text-input id="update_password_password" name="password" type="password" class="sharp-input" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[10px] text-red-600 font-bold uppercase" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Konfirmasi Kata Sandi Baru" class="sharp-label" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="sharp-input" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[10px] text-red-600 font-bold uppercase" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t-2 border-slate-100">
            <button type="submit" class="sharp-btn">
                Perbarui Kata Sandi
            </button>

            @if (session('status') === 'password-updated')
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
