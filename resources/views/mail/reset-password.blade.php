@component('mail::layout')

@php
    $appName = config('app.name');
@endphp

{{-- Badge --}}
<div class="email-badge">Reset Password</div>

{{-- Title --}}
<h1 class="email-title">Reset<br><span style="color: #2563eb;">Password</span></h1>
<p class="email-subtitle">Permintaan reset password diterima</p>

<hr class="email-divider">

{{-- Greeting --}}
<p class="email-text">
    Halo, <strong>{{ $name }}</strong>!
</p>
<p class="email-text">
    Kami menerima permintaan reset password untuk akun ScheduleAI kamu yang terdaftar dengan email <strong>{{ $email }}</strong>.
</p>

{{-- CTA Button --}}
<div class="email-btn-wrap">
    @component('mail::button', ['url' => $url])
        Reset Password Sekarang
    @endcomponent
</div>

{{-- Info box --}}
<div class="email-infobox">
    <p>⏱ Link berlaku selama <strong>{{ $expiry }} menit</strong> sejak email ini dikirim.</p>
    <p>🔒 Jika kamu tidak meminta reset password, abaikan email ini — password kamu aman.</p>
</div>

{{-- URL Fallback --}}
<p class="email-text" style="font-size: 12px; color: #94a3b8;">
    Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke browser:
</p>
<div class="email-url">
    <a href="{{ $url }}">{{ $url }}</a>
</div>

@endcomponent
