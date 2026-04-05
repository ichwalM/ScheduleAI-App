<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun — ScheduleAI</title>
    <meta name="description" content="Buat akun ScheduleAI Anda dan mulai kelola jadwal akademik secara cerdas.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; border-radius: 0 !important; }
        .bg-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 28px 28px; }
        .sharp-input {
            border: 2px solid #0f172a;
            background: #fff;
            outline: none;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: box-shadow 0.15s ease, border-color 0.15s ease;
        }
        .sharp-input:focus { box-shadow: 4px 4px 0px #1e40af; border-color: #1e40af; }
        .sharp-input::placeholder { color: #94a3b8; font-weight: 600; text-transform: uppercase; }
        .sharp-label { font-size: 0.65rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; color: #334155; display: block; margin-bottom: 0.5rem; }
        .sharp-btn {
            background: #0f172a;
            color: #fff;
            border: 2px solid #0f172a;
            padding: 1rem 2rem;
            font-weight: 900;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            transition: all 0.15s ease;
            cursor: pointer;
            width: 100%;
            box-shadow: 4px 4px 0px #1e40af;
        }
        .sharp-btn:hover { background: #1e40af; border-color: #1e40af; box-shadow: 6px 6px 0px #0f172a; }
        .error-msg { color: #dc2626; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 0.4rem; }
    </style>
</head>
<body class="bg-slate-50 bg-grid min-h-screen">

{{-- ── NAV ── --}}
<nav class="border-b-2 border-slate-900 bg-white">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-900 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-black text-xl tracking-tighter uppercase">ScheduleAI</span>
        </a>
        <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition-colors">
            Sudah Punya Akun? Sign In →
        </a>
    </div>
</nav>

{{-- ── MAIN ── --}}
<div class="min-h-[calc(100vh-73px)] grid lg:grid-cols-2">

    {{-- ── LEFT: FORM PANEL ── --}}
    <div class="flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-md">

            <div class="mb-10">
                <span class="inline-block bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 mb-6">
                    Terminal: User Registration
                </span>
                <h1 class="text-4xl font-black uppercase tracking-tighter leading-none mb-3">
                    Buat<br><span class="text-blue-600">Akun</span> Baru
                </h1>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-wide">
                    Mulai kelola jadwal akademik dengan kecerdasan buatan.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="sharp-label">Nama Lengkap</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="sharp-input"
                        placeholder="Nama Lengkap Kamu"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="sharp-label">Alamat Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="sharp-input"
                        placeholder="user@kampus.ac.id"
                        required
                        autocomplete="username"
                    >
                    @error('email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="sharp-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="sharp-input"
                        placeholder="Min. 8 karakter"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="sharp-label">Konfirmasi Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="sharp-input"
                        placeholder="Ulangi password"
                        required
                        autocomplete="new-password"
                    >
                    @error('password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="sharp-btn">
                        Daftar Sekarang →
                    </button>
                </div>

                <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-slate-900 transition-colors">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>

    {{-- ── RIGHT: VISUAL PANEL ── --}}
    <div class="hidden lg:flex flex-col justify-between bg-slate-900 p-16 border-l-2 border-slate-900">
        <div>
            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-12">Keunggulan ScheduleAI</p>
            <h2 class="text-5xl font-black text-white uppercase tracking-tighter leading-none mb-16">
                SMART<br>SCHEDULE<br><span class="text-blue-500">SYSTEM.</span>
            </h2>
            <div class="space-y-8">
                <div class="flex gap-6 items-start border-b border-white/10 pb-8">
                    <div class="w-10 h-10 bg-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-white uppercase mb-1">Analisis Jadwal Otomatis</h4>
                        <p class="text-[11px] text-slate-400 font-bold uppercase leading-relaxed">Upload PDF jadwal kuliah, Gemini AI langsung parsing dan deteksi konflik.</p>
                    </div>
                </div>
                <div class="flex gap-6 items-start border-b border-white/10 pb-8">
                    <div class="w-10 h-10 bg-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-white uppercase mb-1">Multi-Jadwal Support</h4>
                        <p class="text-[11px] text-slate-400 font-bold uppercase leading-relaxed">Kelola jadwal kuliah, magang, dan pekerjaan dalam satu platform terintegrasi.</p>
                    </div>
                </div>
                <div class="flex gap-6 items-start">
                    <div class="w-10 h-10 bg-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-white uppercase mb-1">Profil Publik</h4>
                        <p class="text-[11px] text-slate-400 font-bold uppercase leading-relaxed">Bagikan jadwal kamu melalui link publik. Mudah diakses siapa saja.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 pt-10">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">© 2026 ScheduleAI — Built with precision.</p>
        </div>
    </div>
</div>

</body>
</html>
