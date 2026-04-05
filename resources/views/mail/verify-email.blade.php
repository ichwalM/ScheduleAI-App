@component('mail::layout')

{{-- Badge --}}
<div class="email-badge">Verifikasi Email</div>

{{-- Title --}}
<h1 class="email-title">Verifikasi<br><span style="color: #2563eb;">Emailmu</span></h1>
<p class="email-subtitle">Satu langkah lagi untuk mengaktifkan akun</p>

<hr class="email-divider">

{{-- Greeting --}}
<p class="email-text">
    Halo, <strong>{{ $name }}</strong>! Selamat datang di ScheduleAI! 🎉
</p>
<p class="email-text">
    Terima kasih sudah mendaftar. Kamu hampir selesai! Untuk mulai menggunakan ScheduleAI, klik tombol di bawah untuk memverifikasi email <strong>{{ $email }}</strong>.
</p>

{{-- CTA Button --}}
<div class="email-btn-wrap">
    @component('mail::button', ['url' => $url])
        Verifikasi Email Saya
    @endcomponent
</div>

{{-- Info box --}}
<div class="email-infobox">
    <p>✅ Setelah verifikasi, akun kamu langsung aktif dan siap digunakan.</p>
    <p>🚫 Jika kamu tidak mendaftar di ScheduleAI, abaikan email ini.</p>
</div>

{{-- What you can do section --}}
<hr class="email-divider">
<p class="email-text" style="font-size: 12px; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; margin-bottom: 12px;">
    Setelah verifikasi, kamu bisa:
</p>
<p class="email-text" style="font-size: 13px;">📄 <strong>Upload jadwal kuliah</strong> (PDF/Gambar) untuk dianalisis AI</p>
<p class="email-text" style="font-size: 13px;">⚡ <strong>Deteksi konflik</strong> jadwal secara otomatis</p>
<p class="email-text" style="font-size: 13px;">🌐 <strong>Bagikan jadwal</strong> lewat link publik</p>

{{-- URL Fallback --}}
<hr class="email-divider">
<p class="email-text" style="font-size: 12px; color: #94a3b8;">
    Jika tombol di atas tidak berfungsi, salin URL berikut ke browser:
</p>
<div class="email-url">
    <a href="{{ $url }}">{{ $url }}</a>
</div>

@endcomponent
