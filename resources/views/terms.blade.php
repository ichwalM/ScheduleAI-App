<x-app-layout title="Standard Operating Procedure (SOP)">
    
    <style>
        .sharp-card { background: #fff; border: 2px solid #000; box-shadow: 6px 6px 0px #000; }
    </style>

    {{-- HERO SECTION --}}
    <div class="relative w-full h-48 bg-slate-900 overflow-hidden mb-10 border-b-4 border-blue-600 shadow-[8px_8px_0px_#000]">
        <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ asset('images/doc_campus_1.jpg') }}')"></div>
        <div class="relative z-10 h-full flex flex-row items-center px-10 gap-8">
            <div class="w-20 h-20 bg-blue-600 border-4 border-slate-900 flex items-center justify-center text-white shrink-0 shadow-[4px_4px_0px_#1e40af]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-2">Legal & Privacy Framework</p>
                <h1 class="text-3xl font-black text-white uppercase tracking-tighter leading-none">
                    Standard Operating Procedure
                </h1>
            </div>
            <div class="hidden md:block h-20 w-32 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjZmZmIi8+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiMwMDAiLz4KPC9zdmc+')] opacity-20"></div>
        </div>
    </div>

    {{-- CONTENT LOOP --}}
    <div class="max-w-4xl mx-auto mb-20 space-y-10">
        
        <div class="border-b-4 border-slate-900 pb-4 mb-8">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-1">Berlaku Efektif: {{ date('d F Y') }}</p>
            <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Ketentuan Layanan ScheduleAI</h2>
        </div>

        <div class="sharp-card p-10">
            <div class="prose prose-slate prose-h3:text-blue-600 prose-h3:uppercase prose-h3:font-black prose-h3:tracking-tight max-w-none text-slate-700">
                
                <h3>1. Pengenalan dan Persetujuan</h3>
                <p>Selamat datang di <strong>ScheduleAI</strong>, platform cerdas pengelolaan jadwal universitas. Dengan mendaftar, mengakses, atau menggunakan platform ini, Anda secara hukum menyetujui seluruh syarat dan ketentuan yang diuraikan dalam Standard Operating Procedure (SOP) ini. Jika Anda tidak menyetujui bagian mana pun dari ketentuan ini, mohon untuk tidak melanjutkan proses pendaftaran.</p>

                <h3>2. Manajemen Data Pribadi & Privasi</h3>
                <p>Kami mengutamakan keamanan dan privasi data Anda. Sistem kami dibangun berdasarkan prinsip-prinsip berikut:</p>
                <ul>
                    <li><strong>Data Terkumpul:</strong> Kami hanya mengumpulkan data yang krusial untuk fungsionalitas sistem, seperti nama, email, avatar, dan dokumen jadwal berformat PDF atau Gambar.</li>
                    <li><strong>Kerahasiaan Dokumen:</strong> File jadwal (KRS) yang Anda unggah dilindungi dan disimpan dalam *buffer* kami. Tidak ada pihak eksternal, selain bot AI internal kami (Google Gemini), yang dapat membacanya.</li>
                    <li><strong>Analisis Kecerdasan Buatan (AI):</strong> Data identitas dokumen Anda murni diekstrak hanya untuk keperluan agregasi jadwal, mata kuliah, deteksi konflik, dan ruangan oleh mesin AI kami.</li>
                </ul>

                <h3>3. SOP Manajemen Email Terjadwal</h3>
                <p>Fitur notifikasi adalah tulang punggung layanan kami untuk memastikan kedisiplinan akademis Anda:</p>
                <ul>
                    <li><strong>*Routine Blast*:</strong> Anda menyetujui bahwa sistem penjadwalan otomatis (*Scheduler*) kami berhak mengirimkan email pengingat harian secara massal (pada jam rutin 06:00 WITA atau jam lain).</li>
                    <li><strong>Opt-Out Policy:</strong> Anda diberikan otoritas independen penuh untuk mematikan <em>(disable)</em> notifikasi email harian di menu Pengaturan Profil jika dirasa mengganggu.</li>
                </ul>

                <h3>4. Kewajiban Pengguna</h3>
                <p>Dalam menjalankan ekosistem yang sehat, pengguna diwajibkan untuk mematuhi regulasi di bawah ini:</p>
                <ul>
                    <li>Tidak menggunakan bot berbahaya, teknik eksploitasi, atau melancarkan upaya *Reverse Engineering* (rekayasa balik) pada Terminal operasi.</li>
                    <li>Tidak mengunggah file PDF yang berisi konten ilegal, *malware*, atau tidak berkaitan sama sekali dengan jadwal Universitas.</li>
                    <li>Menjaga keamanan otentikasi kata sandi sendiri secara mutlak dari retasan pihak ketiga. Pihak ScheduleAI dibebaskan dari kerugian data akibat kelalaian pribadi.</li>
                </ul>

                <hr class="my-8 border-slate-200">
                <p class="text-xs font-black uppercase text-slate-500 text-center tracking-widest"><br>ScheduleAI Management System — Core Terminal Protocol</p>
                
            </div>
        </div>
        
        <div class="flex justify-center mt-6">
            <a href="javascript:history.back()" class="bg-slate-900 hover:bg-blue-600 text-white font-black text-xs uppercase px-8 py-3 tracking-widest transition-colors shadow-[4px_4px_0px_#000] border-2 border-slate-900">
                ← Kembali Pendaftaran
            </a>
        </div>

    </div>

</x-app-layout>
