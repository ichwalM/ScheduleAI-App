<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ScheduleAI — Documentation & Project Profile</title>
    <meta name="description" content="Dokumentasi dan profil proyek ScheduleAI — Transformasi jadwal kuliah dengan kecerdasan buatan.">
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
            <div class="w-10 h-10 bg-slate-900 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-black text-2xl tracking-tighter uppercase">ScheduleAI</span>
        </div>
        <div class="hidden md:flex items-center gap-8 text-sm font-bold uppercase tracking-widest">
            <a href="#documentation" class="hover:blue-accent transition-colors">Documentation</a>
            <a href="#features" class="hover:blue-accent transition-colors">Features</a>
            <a href="{{ route('login') }}" class="px-6 py-2 border-2 border-slate-900 hover:bg-slate-900 hover:text-white transition-all">Sign In</a>
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════ HERO ═══════════════════════════════ --}}
<header class="border-b-2 border-slate-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-24 grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <div class="inline-block bg-blue-600 text-white px-4 py-1 text-xs font-bold uppercase tracking-widest mb-8">
                Project Profile v1.0
            </div>
            <h1 class="editorial-title text-7xl md:text-9xl font-black text-slate-900 mb-10">
                TRANSFORMING<br>
                <span class="blue-accent">ACADEMIC</span><br>
                SYSTEMS.
            </h1>
            <p class="text-xl text-slate-600 max-w-lg mb-12 leading-relaxed">
                ScheduleAI bukan sekadar alat manajemen waktu. Ini adalah sistem dokumentasi cerdas yang menggabungkan Google Gemini AI dengan struktur data relasional untuk efisiensi universitas.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="px-10 py-5 bg-slate-900 text-white font-bold uppercase tracking-widest hover:bg-blue-700 transition-all">
                    Start Your Profile
                </a>
            </div>
        </div>
        <div class="relative">
            <div class="border-2 border-slate-900 p-2 bg-white">
                <img src="{{ asset('images/doc_student.jpg') }}" alt="Student Documentation" class="w-full grayscale hover:grayscale-0 transition-all duration-700">
            </div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 border-2 border-slate-900 bg-blue-600 hidden md:flex items-center justify-center p-6 text-white">
                <p class="text-xs font-bold uppercase leading-tight">Dokumentasi Penggunaan Nyata di Kampus</p>
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

        <div class="grid md:grid-cols-3 gap-0 border-2 border-slate-900 bg-slate-900">
            <div class="bg-white border-r-2 border-slate-900 overflow-hidden">
                <img src="{{ asset('images/doc_campus.jpg') }}" alt="Campus Hall" class="w-full h-64 object-cover border-b-2 border-slate-900">
                <div class="p-8">
                    <h3 class="text-xl font-bold uppercase mb-4">01. Lingkungan Akademik</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Implementasi sistem pada skala universitas, memastikan setiap mahasiswa memiliki profil jadwal yang terstruktur dan bebas konflik.</p>
                </div>
            </div>
            <div class="bg-white border-r-2 border-slate-900 overflow-hidden">
                <img src="{{ asset('images/doc_ai.jpg') }}" alt="AI Analysis" class="w-full h-64 object-cover border-b-2 border-slate-900">
                <div class="p-8">
                    <h3 class="text-xl font-bold uppercase mb-4">02. Analisis Presisi AI</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Ditenagai Google Gemini AI untuk ekstraksi data PDF yang akurat, mengubah dokumen mentah menjadi basis data yang dapat dikelola.</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden">
                <div class="h-64 bg-blue-700 flex items-center justify-center p-12">
                    <svg class="w-24 h-24 text-white opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                    </svg>
                </div>
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
        <div class="grid md:grid-cols-2 gap-24">
            <div>
                <h2 class="text-6xl font-black uppercase tracking-tighter leading-none mb-12">
                    STRICT DATA<br>
                    <span class="blue-accent">NORMALIZATION.</span>
                </h2>
                <div class="space-y-12">
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
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-100 p-8 border-2 border-slate-900 border-b-8 flex flex-col justify-end">
                    <span class="text-5xl font-black blue-accent mb-4">100%</span>
                    <p class="text-xs font-bold uppercase">Automated Parsing</p>
                </div>
                <div class="bg-blue-800 p-8 border-2 border-slate-900 border-b-8 flex flex-col justify-end text-white">
                    <span class="text-5xl font-black mb-4">< 30s</span>
                    <p class="text-xs font-bold uppercase">Processing Speed</p>
                </div>
                <div class="col-span-2 border-2 border-slate-900 bg-white p-8 hover-sharp transition-all">
                    <h4 class="text-xl font-bold uppercase mb-4">Gemini AI Engine</h4>
                    <p class="text-sm text-slate-600">Model tercanggih Google yang memastikan setiap variabel dalam jadwal Anda diinterpretasikan dengan benar tanpa kesalahan manusia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════ FOOTER ═══════════════════════════════ --}}
<footer class="bg-slate-900 text-white py-20 px-6">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start gap-16">
        <div>
            <h2 class="text-4xl font-black uppercase tracking-tighter mb-8">ScheduleAI</h2>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 border border-white/20 flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all">FB</a>
                <a href="#" class="w-10 h-10 border border-white/20 flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all">IG</a>
                <a href="#" class="w-10 h-10 border border-white/20 flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all">TW</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-16">
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
                    <li>LARAVEL 11</li>
                    <li>GOOGLE GEMINI AI</li>
                    <li>TAILWIND CSS</li>
                    <li>MYSQL PRIMARY</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-20 pt-10 border-t border-white/10 flex justify-between items-center text-[10px] uppercase font-bold tracking-widest text-slate-500">
        <p>© 2026 ScheduleAI documentation team.</p>
        <p>Built with precision.</p>
    </div>
</footer>

</body>
</html>
