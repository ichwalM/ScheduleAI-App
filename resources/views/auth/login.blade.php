<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ScheduleAI — Authentication Terminal</title>
    <meta name="description" content="Login ke ScheduleAI dan kelola jadwal akademik Anda.">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo-ico.ico') }}">
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
        .status-msg { color: #16a34a; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; background: #f0fdf4; border: 1px solid #16a34a; padding: 0.5rem 0.75rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body class="bg-slate-50 bg-grid min-h-screen">

{{-- ── NAV ── --}}
<nav class="border-b-2 border-slate-900 bg-white">
    <div class="max-w-7xl mx-auto px-6 py-4 md:py-5 flex flex-col md:flex-row items-center justify-between gap-3 md:gap-0">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo/logo.svg') }}" alt="ScheduleAI Logo" class="w-8 h-8 md:w-9 md:h-9 object-contain">
            <span class="font-black text-lg md:text-xl tracking-tighter uppercase">ScheduleAI</span>
        </a>
        <a href="{{ route('register') }}" class="text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition-colors">
            Belum Punya Akun? Daftar →
        </a>
    </div>
</nav>

{{-- ── MAIN ── --}}
<div class="min-h-[calc(100vh-73px)] grid lg:grid-cols-2">

    {{-- ── LEFT: VISUAL PANEL ── --}}
    <div class="hidden lg:flex flex-col justify-between bg-slate-900 p-16 border-r-2 border-slate-900 relative overflow-hidden">
        {{-- Background Illustration --}}
        <img src="{{ asset('images/illustration/Ilustration3.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-screen pointer-events-none" alt="AI Logic">
        
        <div class="relative z-10">
            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-12">Student Intelligence Terminal</p>
            <h2 class="text-6xl font-black text-white uppercase tracking-tighter leading-none mb-16">
                KELOLA<br>JADWAL<br><span class="text-blue-500">CERDAS.</span>
            </h2>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-0 border-2 border-white/10">
                <div class="bg-white/5 p-6 border-r border-b border-white/10">
                    <p class="text-3xl font-black text-white mb-1">AI</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Powered Parsing</p>
                </div>
                <div class="bg-blue-600/20 p-6 border-b border-white/10">
                    <p class="text-3xl font-black text-blue-400 mb-1">Auto</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Conflict Detect</p>
                </div>
                <div class="bg-white/5 p-6 border-r border-white/10">
                    <p class="text-3xl font-black text-white mb-1">∞</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Multi Schedule</p>
                </div>
                <div class="bg-white/5 p-6 border-white/10">
                    <p class="text-3xl font-black text-emerald-400 mb-1">Live</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Public Profile</p>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 pt-10 flex flex-col gap-3">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                © 2026 ScheduleAI — Built by <a href="https://app.walldev.my.id/" target="_blank" class="text-white hover:text-blue-400 hover:underline transition-all">Ichwal</a>.
            </p>
            <div class="flex gap-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                <a href="https://github.com/ichwalM" target="_blank" class="hover:text-white transition-colors">GitHub</a>
                <a href="https://www.linkedin.com/in/ichwal/" target="_blank" class="hover:text-white transition-colors">LinkedIn</a>
                <a href="https://app.walldev.my.id/" target="_blank" class="hover:text-white transition-colors">Portfolio</a>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: FORM PANEL ── --}}
    <div class="flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-md">

            <div class="mb-10">
                <span class="inline-block bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 mb-6">
                    Terminal: Authentication
                </span>
                <h1 class="text-4xl font-black uppercase tracking-tighter leading-none mb-3">
                    Masuk ke<br><span class="text-blue-600">Dashboard</span>
                </h1>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-wide">
                    Akses seluruh fitur manajemen jadwal Anda.
                </p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="status-msg">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                        autofocus
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
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="w-4 h-4 border-2 border-slate-900 accent-blue-600">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-[11px] font-black text-blue-600 uppercase tracking-widest hover:text-slate-900 transition-colors">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="sharp-btn">
                        Masuk ke Terminal →
                    </button>
                </div>

                <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-slate-900 transition-colors">Daftar sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>
