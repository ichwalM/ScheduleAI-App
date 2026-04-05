<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email — ScheduleAI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; border-radius: 0 !important; }
        .bg-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 28px 28px; }
        .sharp-btn { background: #0f172a; color: #fff; border: 2px solid #0f172a; padding: 1rem 2rem; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; transition: all 0.15s ease; cursor: pointer; box-shadow: 4px 4px 0px #1e40af; display: inline-block; text-align: center; }
        .sharp-btn:hover { background: #1e40af; border-color: #1e40af; box-shadow: 6px 6px 0px #0f172a; }
        .success-msg { color: #16a34a; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; background: #f0fdf4; border: 2px solid #16a34a; padding: 0.75rem 1rem; }
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
    </div>
</nav>

<div class="min-h-[calc(100vh-73px)] flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-lg">

        {{-- Animated Envelope Icon --}}
        <div class="relative w-20 h-20 bg-blue-600 flex items-center justify-center mb-8 shadow-[6px_6px_0px_#0f172a]">
            <svg class="w-11 h-11 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            {{-- Notification dot --}}
            <div class="absolute -top-2 -right-2 w-5 h-5 bg-amber-400 border-2 border-white flex items-center justify-center">
                <span class="text-[8px] font-black text-slate-900">!</span>
            </div>
        </div>

        <div class="mb-8">
            <span class="inline-block bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 mb-4">Terminal: Email Verification</span>
            <h1 class="text-4xl font-black uppercase tracking-tighter leading-none mb-3">Cek<br><span class="text-blue-600">Emailmu</span></h1>
            <p class="text-sm text-slate-500 font-bold uppercase tracking-wide leading-relaxed">
                Kami mengirimkan link verifikasi ke <strong class="text-slate-800">{{ auth()->user()->email }}</strong>. Klik link tersebut untuk mengaktifkan akun.
            </p>
        </div>

        {{-- Success status --}}
        @if (session('status') == 'verification-link-sent')
            <div class="success-msg flex items-center gap-3 mb-6">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Email verifikasi baru berhasil dikirim. Cek inbox kamu!</span>
            </div>
        @endif

        {{-- Steps --}}
        <div class="border-2 border-slate-900 bg-white mb-8 overflow-hidden shadow-[4px_4px_0px_#0f172a]">
            <div class="px-6 py-4 bg-slate-900 border-b-2 border-slate-900">
                <p class="text-[10px] font-black uppercase tracking-widest text-white">Langkah Verifikasi</p>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-7 h-7 bg-emerald-500 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-[11px] font-black uppercase text-slate-500">Akun berhasil didaftarkan</p>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-7 h-7 bg-amber-400 flex items-center justify-center shrink-0 animate-pulse">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-black uppercase text-slate-900">Klik link di email</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-0.5">Menunggu verifikasi...</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 px-6 py-4 opacity-40">
                    <div class="w-7 h-7 bg-slate-200 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <p class="text-[11px] font-black uppercase text-slate-400">Akses dashboard</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <button type="submit" class="sharp-btn w-full">
                    Kirim Ulang Email →
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full sm:w-auto border-2 border-slate-300 text-slate-500 px-8 py-4 text-[11px] font-black uppercase tracking-widest hover:border-red-600 hover:text-red-600 transition-colors">
                    Keluar
                </button>
            </form>
        </div>

        <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-8">
            Tidak menerima email? Cek folder spam/junk kamu.
        </p>
    </div>
</div>

</body>
</html>
