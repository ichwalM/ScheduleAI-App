<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ScheduleAI — Register Terminal</title>
    <meta name="description" content="Daftar ke ScheduleAI dan kelola jadwal akademik Anda.">
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
        <a href="{{ route('login') }}" class="text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition-colors">
            Sudah Punya Akun? Sign In →
        </a>
    </div>
</nav>

{{-- ── MAIN ── --}}
<div class="min-h-[calc(100vh-73px)] grid lg:grid-cols-2">

    {{-- ── LEFT: FORM PANEL ── --}}
    <div class="flex items-center justify-center px-6 py-16" x-data="{ showSopModal: false }">
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

                {{-- Terms and Conditions SOP --}}
                <div class="flex items-start gap-3 border border-slate-200 p-4 bg-white">
                    <input type="checkbox" name="terms" id="terms" class="mt-1 w-4 h-4 text-blue-600 border-2 border-slate-900 rounded-none focus:ring-blue-600 shrink-0" {{ old('terms') ? 'checked' : '' }} required>
                    <label for="terms" class="text-[10px] font-bold text-slate-600 leading-relaxed uppercase tracking-wide">
                        Saya menyetujui seluruh <button type="button" @click="showSopModal = true" class="text-blue-600 underline hover:text-blue-800 transition-colors cursor-pointer font-black">Standard Operating Procedure (SOP)</button> penggunaan ScheduleAI, termasuk analisis otomatis pada dokumen jadwal, serta manajemen notifikasi email harian.
                    </label>
                </div>
                @error('terms')
                    <p class="error-msg">{{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="sharp-btn">
                        Daftar Penuh →
                    </button>
                </div>

                <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-slate-900 transition-colors">Masuk di sini</a>
                </p>
            </form>

            {{-- SOP MODAL --}}
            <div x-show="showSopModal" 
                 style="display: none;" 
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 backdrop-blur-none"
                 x-transition:enter-end="opacity-100 backdrop-blur-sm"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 backdrop-blur-sm"
                 x-transition:leave-end="opacity-0 backdrop-blur-none">
                 
                <div class="bg-white border-4 border-slate-900 shadow-[8px_8px_0px_#000] max-w-2xl w-full max-h-[90vh] flex flex-col relative"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     @click.away="showSopModal = false">
                    
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between border-b-4 border-slate-900 p-6 bg-slate-50">
                        <div>
                            <p class="text-[10px] font-black uppercase text-blue-600 tracking-widest mb-1">Legal Framework</p>
                            <h2 class="text-2xl font-black uppercase tracking-tighter text-slate-900">Standard Operating Procedure</h2>
                        </div>
                        <button @click="showSopModal = false" class="text-slate-400 hover:text-red-600 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="p-8 overflow-y-auto prose prose-slate prose-h3:text-blue-600 prose-h3:uppercase prose-h3:font-black prose-h3:tracking-tight max-w-none text-slate-700 text-sm">
                        <h3>1. Pengenalan dan Persetujuan</h3>
                        <p>Selamat datang di <strong>ScheduleAI</strong>, platform cerdas pengelolaan jadwal universitas. Dengan mendaftar, mengakses, atau menggunakan platform ini, Anda menyetujui seluruh ketentuan dalam sistem.</p>

                        <h3>2. Manajemen Data Pribadi & Privasi</h3>
                        <p>Sistem kami dibangun berdasarkan prinsip keamanan ketat:</p>
                        <ul>
                            <li><strong>Kerahasiaan Dokumen:</strong> File KRS/Jadwal hanya dikonsumsi sementara secara terisolasi.</li>
                            <li><strong>Ekstraksi AI (Gemini):</strong> Data PDF hanya dibaca untuk mengumpulkan informasi nama kelas, jam, dosen, dan bobot SKS.</li>
                        </ul>

                        <h3>3. Manajemen Email Terjadwal</h3>
                        <ul>
                            <li><strong>Routine Blast:</strong> Kami berhak mengirim spam peringatan/jadwal pada pagi hari (06:00 WITA).</li>
                            <li><strong>Opt-Out:</strong> Anda memiliki hak penuh untuk menonaktifkan spam ini dari menu Pengaturan Profil kapan saja.</li>
                        </ul>

                        <h3>4. Kewajiban Etis Pengendali</h3>
                        <ul>
                            <li>Dilarang menyebarkan file *reverse shell*, *payload*, maupun *malware* lewat form pengunggahan file!</li>
                            <li>Amankan otentikasi login Anda sendiri dengan mutlak.</li>
                        </ul>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="border-t-4 border-slate-900 p-6 flex justify-end bg-slate-50">
                        <button type="button" @click="showSopModal = false" class="bg-blue-600 hover:bg-slate-900 border-2 border-slate-900 text-white font-black text-xs uppercase px-8 py-3 tracking-widest transition-colors shadow-[4px_4px_0px_#000]">
                            Saya Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: VISUAL PANEL ── --}}
    <div class="hidden lg:flex flex-col justify-between bg-slate-900 p-16 border-l-2 border-slate-900 relative overflow-hidden">
        {{-- Background Illustration --}}
        <img src="{{ asset('images/illustration/Ilustration2.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-screen pointer-events-none" alt="AI Engine">
        
        <div class="relative z-10">
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
</div>

</body>
</html>
