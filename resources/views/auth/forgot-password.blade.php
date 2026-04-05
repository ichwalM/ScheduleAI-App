<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password — ScheduleAI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; border-radius: 0 !important; }
        .bg-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 28px 28px; }
        .sharp-input { border: 2px solid #0f172a; background: #fff; outline: none; width: 100%; padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; transition: box-shadow 0.15s ease, border-color 0.15s ease; }
        .sharp-input:focus { box-shadow: 4px 4px 0px #1e40af; border-color: #1e40af; }
        .sharp-input::placeholder { color: #94a3b8; font-weight: 600; text-transform: uppercase; }
        .sharp-label { font-size: 0.65rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; color: #334155; display: block; margin-bottom: 0.5rem; }
        .sharp-btn { background: #0f172a; color: #fff; border: 2px solid #0f172a; padding: 1rem 2rem; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; transition: all 0.15s ease; cursor: pointer; width: 100%; box-shadow: 4px 4px 0px #1e40af; }
        .sharp-btn:hover { background: #1e40af; border-color: #1e40af; box-shadow: 6px 6px 0px #0f172a; }
        .error-msg { color: #dc2626; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 0.4rem; }
        .success-msg { color: #16a34a; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; background: #f0fdf4; border: 2px solid #16a34a; padding: 0.75rem 1rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body class="bg-slate-50 bg-grid min-h-screen">

<nav class="border-b-2 border-slate-900 bg-white">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-900 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span class="font-black text-xl tracking-tighter uppercase">ScheduleAI</span>
        </a>
        <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition-colors">← Kembali ke Login</a>
    </div>
</nav>

<div class="min-h-[calc(100vh-73px)] flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-lg">

        {{-- Icon --}}
        <div class="w-16 h-16 bg-amber-500 flex items-center justify-center mb-8 shadow-[4px_4px_0px_#0f172a]">
            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>

        <div class="mb-8">
            <span class="inline-block bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 mb-4">Terminal: Password Recovery</span>
            <h1 class="text-4xl font-black uppercase tracking-tighter leading-none mb-3">Lupa<br><span class="text-amber-500">Password?</span></h1>
            <p class="text-sm text-slate-500 font-bold uppercase tracking-wide leading-relaxed">
                Masukkan email kamu. Kami akan mengirimkan link reset password yang valid selama 60 menit.
            </p>
        </div>

        {{-- Status --}}
        @if (session('status'))
            <div class="success-msg flex items-center gap-3 mb-6">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="sharp-label">Alamat Email Terdaftar</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="sharp-input" placeholder="user@kampus.ac.id" required autofocus>
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="sharp-btn">
                Kirim Link Reset Password →
            </button>
            <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                Ingat password? <a href="{{ route('login') }}" class="text-blue-600 hover:text-slate-900 transition-colors">Masuk di sini</a>
            </p>
        </form>

        {{-- Info box --}}
        <div class="mt-10 border-2 border-slate-200 p-6 bg-white">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Catatan Penting</p>
            <ul class="space-y-2">
                <li class="flex items-start gap-2 text-[11px] font-bold text-slate-500 uppercase">
                    <span class="w-1.5 h-1.5 bg-blue-600 mt-1.5 shrink-0"></span>
                    Link reset password berlaku selama 60 menit.
                </li>
                <li class="flex items-start gap-2 text-[11px] font-bold text-slate-500 uppercase">
                    <span class="w-1.5 h-1.5 bg-blue-600 mt-1.5 shrink-0"></span>
                    Cek folder spam/junk jika email belum masuk.
                </li>
                <li class="flex items-start gap-2 text-[11px] font-bold text-slate-500 uppercase">
                    <span class="w-1.5 h-1.5 bg-blue-600 mt-1.5 shrink-0"></span>
                    Pastikan email yang dimasukkan sama dengan yang digunakan saat daftar.
                </li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
