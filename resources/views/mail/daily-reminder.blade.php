@component('mail::layout')

{{-- Badge --}}
<div class="email-badge">Daily Agenda</div>

{{-- Title --}}
<h1 class="email-title">{{ ucfirst(strtolower($day)) }}<br><span style="color: #2563eb;">Morning</span></h1>
<p class="email-subtitle">Kamu punya {{ $items->count() }} agenda hari ini.</p>

<hr class="email-divider">

{{-- Greeting --}}
<p class="email-text">
    Halo, <strong>{{ $user->name }}</strong>!
</p>
<p class="email-text">
    Berikut adalah ringkasan jadwal kuliah dan kegiatanmu hari ini. Siapkan dirimu dan jangan sampai terlambat!
</p>

{{-- Agenda Table / List --}}
<div style="margin: 32px 0;">
@foreach($items as $item)
<div style="border-left: 4px solid {{ $item->is_activity ? '#059669' : '#2563eb' }}; background: #f8fafc; padding: 16px; margin-bottom: 12px; border-radius: 0; border-top: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
<div style="font-size: 11px; font-weight: 900; color: {{ $item->is_activity ? '#059669' : '#2563eb' }}; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">
{{ $item->time_start }} - {{ $item->time_end }} &nbsp;|&nbsp; <span style="color: #64748b;">{{ $item->is_activity ? 'JOB/KEGIATAN' : 'KULIAH' }}</span>
</div>
<div style="font-size: 16px; font-weight: 800; color: #0f172a; text-transform: uppercase; line-height: 1.2; margin-bottom: 6px;">
{{ $item->is_activity ? $item->title : $item->name }}
</div>
<div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">
📍 Lokasi: {{ $item->is_activity ? ($item->location ?? '-') : ($item->room ?? '-') }}
@if(!$item->is_activity)
&nbsp;|&nbsp; 📌 KELAS: {{ $item->class ?? '-' }} &nbsp;|&nbsp; 🎓 SKS: {{ $item->credits }}
@endif
</div>
</div>
@endforeach
</div>

{{-- Info box --}}
<div class="email-infobox">
    <p>⚡ Mengecek jadwal manual? Sekarang gampang!</p>
    <p>Akses dashboard ScheduleAI kamu lewat tombol di bawah ini.</p>
</div>

{{-- CTA Button --}}
<div class="email-btn-wrap" style="text-align: center;">
    @component('mail::button', ['url' => 'https://schedule.walldev.my.id/student/dashboard'])
        Buka Dashboard
    @endcomponent
</div>

<hr class="email-divider">
<p class="email-text" style="font-size: 11px; color: #94a3b8; text-align: center;">
    Pengingat ini dikirimkan otomatis oleh ScheduleAI System.
</p>

@endcomponent
