<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap');
    body { font-family: 'Inter', Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; }
    .email-wrapper { background-color: #f1f5f9; padding: 40px 20px; }
    .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; border: 2px solid #0f172a; }
    /* Header */
    .email-header { background-color: #0f172a; padding: 32px 40px; border-bottom: 4px solid #2563eb; }
    .email-logo { display: inline-flex; align-items: center; gap: 12px; }
    .email-logo-icon { width: 40px; height: 40px; background: #2563eb; display: inline-flex; align-items: center; justify-content: center; }
    .email-logo-text { color: #ffffff; font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: -0.04em; }
    /* Body */
    .email-body { padding: 48px 40px; }
    .email-badge { display: inline-block; background: #2563eb; color: #ffffff; font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; padding: 4px 12px; margin-bottom: 20px; }
    .email-title { font-size: 32px; font-weight: 900; color: #0f172a; text-transform: uppercase; letter-spacing: -0.04em; line-height: 1; margin: 0 0 12px 0; }
    .email-subtitle { font-size: 13px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 32px 0; }
    .email-divider { border: none; border-top: 2px solid #e2e8f0; margin: 32px 0; }
    .email-text { font-size: 14px; color: #475569; font-weight: 500; line-height: 1.7; margin: 0 0 20px 0; }
    /* Button */
    .email-btn-wrap { margin: 32px 0; }
    .email-btn { display: inline-block; background: #0f172a; color: #ffffff !important; text-decoration: none; font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.12em; padding: 16px 40px; border: 2px solid #0f172a; box-shadow: 4px 4px 0px #2563eb; }
    /* Info box */
    .email-infobox { background: #f8fafc; border: 2px solid #e2e8f0; border-left: 4px solid #2563eb; padding: 16px 20px; margin: 24px 0; }
    .email-infobox p { font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 6px 0; }
    .email-infobox p:last-child { margin: 0; }
    /* URL fallback */
    .email-url { background: #f1f5f9; border: 2px solid #e2e8f0; padding: 12px 16px; margin: 20px 0; word-break: break-all; }
    .email-url a { font-size: 11px; color: #2563eb; font-weight: 600; text-decoration: underline; }
    /* Footer */
    .email-footer { background: #0f172a; padding: 24px 40px; border-top: 2px solid #1e293b; }
    .email-footer p { font-size: 11px; color: #475569; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin: 0; }
    /* Responsive */
    @media only screen and (max-width: 600px) {
        .email-body { padding: 32px 24px; }
        .email-header { padding: 24px; }
        .email-title { font-size: 24px; }
        .email-btn { display: block; text-align: center; }
    }
</style>
{!! $head ?? '' !!}
</head>
<body>
<div class="email-wrapper">
<div class="email-container">

    {{-- Header --}}
    <div class="email-header">
        <div class="email-logo">
            <div class="email-logo-icon">
                <svg width="22" height="22" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="email-logo-text">ScheduleAI</span>
        </div>
    </div>

    {{-- Body --}}
    <div class="email-body">
        {!! Illuminate\Mail\Markdown::parse($slot) !!}
        {!! $subcopy ?? '' !!}
    </div>

    {{-- Footer --}}
    <div class="email-footer">
        <p>© {{ date('Y') }} ScheduleAI — Sistem Manajemen Jadwal Akademik Berbasis AI</p>
    </div>

</div>
</div>
</body>
</html>
