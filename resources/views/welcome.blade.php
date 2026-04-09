<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ScheduleAI — Documentation & Project Profile</title>
    <meta name="description" content="Dokumentasi dan profil proyek ScheduleAI — Transformasi jadwal kuliah dengan kecerdasan buatan.">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo-ico.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; border-radius: 0 !important; }
        .sharp-border { border: 1px solid #e2e8f0; }
        .bg-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 30px 30px; }
        .editorial-title { letter-spacing: -0.05em; line-height: 0.9; }
        .blue-accent { color: #1e40af; }
        .bg-blue-accent { background-color: #1e40af; }
        .hover-sharp:hover { transform: translate(-4px, -4px); box-shadow: 8px 8px 0px #1e40af; transition: all 0.2s ease; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased bg-grid">

{{-- ═══════════════════════════════ NAVIGATION ═══════════════════════════════ --}}
<nav class="border-b-2 border-slate-900 bg-white sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo/logo.svg') }}" alt="ScheduleAI Logo" class="w-10 h-10 object-contain">
            <span class="font-black text-2xl tracking-tighter uppercase">Schedule <span class="blue-accent">AI</span></span>
        </div>
        <div class="flex items-center gap-4 text-sm font-bold uppercase tracking-widest">
            <a href="#documentation" class="hidden md:block hover:blue-accent transition-colors">Documentation</a>
            <a href="#features" class="hidden md:block hover:blue-accent transition-colors">Features</a>
            <a href="{{ route('login') }}" class="px-4 py-2 md:px-6 md:py-2 border-2 border-slate-900 hover:bg-slate-900 hover:text-white transition-all text-xs md:text-sm">Sign In</a>
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════ HERO ═══════════════════════════════ --}}
<header class="border-b-2 border-slate-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-12 items-center">
        {{-- Left: Text --}}
        <div class="min-w-0 overflow-hidden">
            <div class="inline-block bg-blue-600 text-white px-4 py-1 text-xs font-bold uppercase tracking-widest mb-8">
                Project Profile v1.0
            </div>
            <h1 class="editorial-title font-black text-slate-900 mb-10 break-words" style="font-size: clamp(2rem, 5vw, 4.5rem); line-height: 0.9; letter-spacing: -0.04em;">
                TRANSFORMING<br>
                <span class="blue-accent">ACADEMIC</span><br>
                SYSTEMS.
            </h1>
            <p class="text-base text-slate-600 max-w-md mb-12 leading-relaxed">
                ScheduleAI bukan sekadar alat manajemen waktu. Ini adalah sistem dokumentasi cerdas yang menggabungkan Google Gemini AI dengan struktur data relasional untuk efisiensi universitas.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 sm:px-10 sm:py-5 bg-slate-900 text-white font-bold uppercase tracking-widest text-xs hover:bg-blue-700 transition-all text-center">
                    Start Your Profile
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 sm:px-10 sm:py-5 border-2 border-slate-900 text-slate-900 font-bold uppercase tracking-widest text-xs hover:bg-slate-900 hover:text-white transition-all text-center">
                    Sign In
                </a>
            </div>
        </div>
        {{-- Right: Image --}}
        <div class="relative min-w-0">
            <div class="border-2 border-slate-900 p-2 bg-white shadow-[8px_8px_0px_#0f172a]">
                <img src="{{ asset('images/illustration/Ilustration1.webp') }}" alt="Student Documentation" class="w-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
            </div>
            <div class="absolute -bottom-4 -left-4 w-40 h-40 border-2 border-slate-900 bg-blue-600 hidden lg:flex items-center justify-center p-6 text-white">
                <span class="text-5xl font-black">99%</span>
            </div>
        </div>
    </div>
</header>

{{-- ═══════════════════════════════ DOCUMENTATION SECTION ═══════════════════════════════ --}}
<section id="documentation" class="py-24 border-b-2 border-slate-900 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-20">
            <h2 class="text-5xl font-black uppercase tracking-tighter mb-4">Project Documentation</h2>
            <div class="w-24 h-2 bg-blue-600"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border-2 border-slate-900 bg-slate-900">
            <div class="bg-white border-b-2 md:border-b-0 md:border-r-2 border-slate-900 overflow-hidden">
                <img src="{{ asset('images/illustration/Ilustration2.webp') }}" alt="Campus Hall" class="w-full h-48 md:h-64 object-cover border-b-2 border-slate-900 filter saturate-50">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg md:text-xl font-bold uppercase mb-4">01. Lingkungan Akademik</h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Implementasi sistem pada skala universitas, memastikan setiap mahasiswa memiliki profil jadwal yang terstruktur dan bebas konflik.</p>
                </div>
            </div>
            <div class="bg-white border-b-2 md:border-b-0 md:border-r-2 border-slate-900 overflow-hidden">
                <img src="{{ asset('images/illustration/Ilustration3.webp') }}" alt="AI Analysis" class="w-full h-48 md:h-64 object-cover border-b-2 border-slate-900 filter saturate-50">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg md:text-xl font-bold uppercase mb-4">02. Analisis Presisi AI</h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Ditenagai Google Gemini AI untuk ekstraksi data PDF yang akurat, mengubah dokumen mentah menjadi basis data yang dapat dikelola.</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden">
                <img src="{{ asset('images/documentations/schedules.png') }}" alt="Schedule Output" class="w-full h-48 md:h-64 object-cover border-b-2 border-slate-900 filter saturate-50">
                <div class="p-8">
                    <h3 class="text-xl font-bold uppercase mb-4">03. Rekomendasi Pintar</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Sistem memberikan saran optimasi berbasis Bahasa Indonesia, membantu mahasiswa memaksimalkan waktu perkuliahan mereka.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════ FEATURES ═══════════════════════════════ --}}
<section id="features" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-4">System Features</h2>
                <div class="w-24 h-2 bg-blue-600 mb-8"></div>
                <p class="text-slate-600 font-medium max-w-sm">Dirancang dengan arsitektur ketat untuk mengeliminasi bentrok jadwal dan menyediakan data yang tervalidasi seketika.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-12">
                <div class="flex gap-6">
                    <span class="text-4xl font-black text-slate-200">01</span>
                    <div>
                        <h4 class="text-lg font-bold uppercase mb-2">Relational Table Storage</h4>
                        <p class="text-slate-500">Bukan sekadar JSON. Data Anda dipetakan ke tabel normal (Courses, Conflicts, Recommendations) untuk fleksibilitas edit maksimal.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <span class="text-4xl font-black text-slate-200">02</span>
                    <div>
                        <h4 class="text-lg font-bold uppercase mb-2">Profile Centralization</h4>
                        <p class="text-slate-500">Panel Admin yang tegas untuk memantau aktivitas mahasiswa, status analisis, dan manajemen data terpusat.</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div class="bg-slate-100 p-4 md:p-8 border-2 border-slate-900 border-b-8 flex flex-col justify-end">
                    <span class="text-3xl md:text-5xl font-black blue-accent mb-2 md:mb-4">100%</span>
                    <p class="text-[10px] md:text-xs font-bold uppercase">Automated Parsing</p>
                </div>
                <div class="bg-blue-800 p-4 md:p-8 border-2 border-slate-900 border-b-8 flex flex-col justify-end text-white">
                    <span class="text-3xl md:text-5xl font-black mb-2 md:mb-4">< 30s</span>
                    <p class="text-[10px] md:text-xs font-bold uppercase">Processing Speed</p>
                </div>
                <div class="col-span-2 border-2 border-slate-900 bg-white p-5 md:p-8 hover-sharp transition-all">
                    <h4 class="text-lg md:text-xl font-bold uppercase mb-2 md:mb-4">Gemini AI Engine</h4>
                    <p class="text-xs md:text-sm text-slate-600 break-words">Model tercanggih Google yang memastikan setiap variabel dalam jadwal Anda diinterpretasikan dengan benar tanpa kesalahan manusia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════ FOOTER ═══════════════════════════════ --}}
<footer class="bg-slate-900 text-white py-20 px-6">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start gap-16">
        <div>
            <h2 class="text-4xl font-black uppercase tracking-tighter mb-8">Schedule<span class="blue-accent">AI</span></h2>
            <div class="flex gap-4">
                <a href="https://github.com/ichwalM" class="w-10 h-10 border border-white/20 flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.601.11.818-.264.818-.592 0-.291-.011-1.06-.015-2.092-3.338.724-4.042-1.61-4.042-1.61-.546-1.392-1.334-1.768-1.334-1.768-1.09-.744.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222 0 1.604-.015 2.898-.015 3.294 0 .329.215.701.828.588C20.584 21.81 24 17.306 24 12c0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/in/ichwal/" class="w-10 h-10 border border-white/20 flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                    </svg>
                </a>
                <a href="https://app.walldev.my.id/" class="w-10 h-10 border border-white/20 flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all">
                    <span class="text-[10px] font-bold">WWW</span>
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 md:gap-16 mt-12 md:mt-0">
            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6">Internal Links</h5>
                <ul class="space-y-4 text-sm font-semibold uppercase">
                    <li><a href="{{ route('login') }}" class="hover:text-blue-400 text-xs">Sign In</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-blue-400 text-xs">Register</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6">Tech Stack</h5>
                <ul class="space-y-2 text-xs font-mono text-slate-500">
                    <li>LARAVEL 12</li>
                    <li>GOOGLE GEMINI AI</li>
                    <li>TAILWIND CSS</li>
                    <li>MYSQL PRIMARY</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-20 pt-10 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] uppercase font-bold tracking-widest text-slate-500">
        <p>© 2026 ScheduleAI. Developed by <a href="https://app.walldev.my.id/" target="_blank" class="text-white hover:text-blue-500 hover:underline transition-all">Ichwal</a>.</p>
        <div class="flex gap-6">
            <a href="https://github.com/ichwalM" target="_blank" class="hover:text-white transition-colors">GitHub</a>
            <a href="https://www.linkedin.com/in/ichwal/" target="_blank" class="hover:text-white transition-colors">LinkedIn</a>
            <a href="https://app.walldev.my.id/" target="_blank" class="hover:text-white transition-colors">Portfolio</a>
        </div>
    </div>  
</footer>

</body>
</html>
