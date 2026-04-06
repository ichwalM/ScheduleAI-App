<section class="space-y-6">
    <p class="text-xs text-red-600 font-bold uppercase tracking-widest leading-relaxed mb-6 border-l-4 border-red-600 pl-4 bg-red-50 py-2">
        Aksi ini tidak dapat dibatalkan. Setelah dihapus, semua data dan sumber daya milikmu akan dihilangkan secara permanen.
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="sharp-btn-danger w-full sm:w-auto"
    >
        Hapus Akun Permanen
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 border-4 border-red-600 bg-white">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-4">
                Yakin Ingin Menghapus<br><span class="text-red-600">Akun Ini?</span>
            </h2>

            <p class="text-xs text-slate-600 font-bold leading-relaxed mb-6 uppercase tracking-widest">
                Tindakan berbahaya! Silakan masukkan kata sandi Anda untuk memastikan bahwa Anda benar-benar ingin menghapus akun secara permanen.
            </p>

            <div class="mb-6">
                <x-input-label for="password" value="Kata Sandi Verifikasi" class="sharp-label" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="sharp-input focus:border-red-600 focus:ring-red-600"
                    placeholder="Masukkan sandi..."
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] text-red-600 font-bold uppercase" />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="sharp-btn-danger w-full text-center">
                    Ya, Hapus Permanen
                </button>
                <button type="button" x-on:click="$dispatch('close')" class="sharp-btn bg-slate-200 border-slate-300 text-slate-600 hover:bg-slate-300 hover:text-slate-900 w-full text-center">
                    Batal
                </button>
            </div>
        </form>
    </x-modal>
</section>
