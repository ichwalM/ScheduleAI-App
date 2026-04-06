<x-app-layout title="Pengaturan Profil">

    <style>
        .sharp-card  { border-radius: 0 !important; border: 2px solid #000; background: #fff; }
        .sharp-input { border-radius: 0 !important; border: 2px solid #0f172a; padding: 0.75rem 1rem; width: 100%; font-size: 0.875rem; font-weight: 600; outline: none; transition: all 0.15s ease; }
        .sharp-input:focus { box-shadow: 4px 4px 0px #1e40af; border-color: #1e40af; }
        .sharp-label { font-size: 0.65rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; color: #334155; display: block; margin-bottom: 0.5rem; }
        .sharp-btn   { border-radius: 0 !important; border: 2px solid #0f172a; background: #0f172a; color: #fff; text-transform: uppercase; font-weight: 900; letter-spacing: 0.1em; padding: 0.75rem 1.5rem; transition: all 0.15s ease; box-shadow: 4px 4px 0px #1e40af; }
        .sharp-btn:hover { background: #1e40af; box-shadow: 6px 6px 0px #0f172a; }
        .sharp-btn-danger { border-radius: 0 !important; border: 2px solid #dc2626; background: #fff; color: #dc2626; text-transform: uppercase; font-weight: 900; letter-spacing: 0.1em; padding: 0.75rem 1.5rem; transition: all 0.15s ease; box-shadow: 4px 4px 0px #dc2626; }
        .sharp-btn-danger:hover { background: #dc2626; color: #fff; box-shadow: 6px 6px 0px #991b1b; }
        .toggle-checkbox:checked { right: 0; border-color: #2563eb; }
        .toggle-checkbox:checked + .toggle-label { background-color: #2563eb; }
    </style>

    {{-- ═══ HERO ═══ --}}
    <div class="relative w-full h-36 bg-slate-900 overflow-hidden mb-8 border-b-4 border-blue-600">
        <div class="relative z-10 h-full flex flex-col justify-center px-10 border-l-8 border-blue-600">
            <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-1">Terminal: Global Settings</p>
            <h1 class="text-4xl font-black text-white uppercase tracking-tighter leading-none">
                Profil & Pengaturan
            </h1>
            <p class="text-white/50 text-[10px] font-bold uppercase tracking-widest mt-2">
                Manajemen Identitas, Keamanan, & Sistem Notifikasi
            </p>
        </div>
    </div>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        {{-- Kolom Kiri: Profil & Identitas --}}
        <div class="xl:col-span-2 space-y-8">
            <div class="sharp-card overflow-hidden shadow-[8px_8px_0px_#0f172a]">
                <div class="px-8 py-5 bg-slate-900 border-b-2 border-slate-900 flex items-center justify-between">
                    <h2 class="text-sm font-black uppercase tracking-widest text-white">Identitas & Kontak</h2>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="sharp-card overflow-hidden shadow-[8px_8px_0px_#0f172a]">
                <div class="px-8 py-5 bg-slate-900 border-b-2 border-slate-900">
                    <h2 class="text-sm font-black uppercase tracking-widest text-white">Keamanan Kata Sandi</h2>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Danger Zone dll --}}
        <div class="xl:col-span-1 space-y-8">
            {{-- Info Box --}}
            <div class="sharp-card p-6 border-l-8 border-amber-400" style="box-shadow: 4px 4px 0px #d97706;">
                <p class="text-[10px] font-black uppercase tracking-widest text-amber-600 mb-2">Panduan Sistem</p>
                <p class="text-xs text-slate-600 font-bold leading-relaxed mb-4">
                    Foto Avatar akan digunakan sebagai identitas publik jika kamu membagikan jadwal. Pastikan email selalu aktif untuk fitur Notifikasi Alarm Harian.
                </p>
                <a href="{{ route('student.dashboard') }}" class="text-[10px] font-black uppercase text-blue-600 hover:text-slate-900 underline">← Kembali ke Dashboard</a>
            </div>

            {{-- Danger Zone --}}
            <div class="sharp-card overflow-hidden border-2 border-red-200">
                <div class="px-6 py-4 bg-red-50 border-b-2 border-red-200">
                    <h2 class="text-xs font-black uppercase tracking-widest text-red-600">Danger Zone</h2>
                </div>
                <div class="p-6 bg-white">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
