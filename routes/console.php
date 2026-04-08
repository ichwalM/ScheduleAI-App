<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

// Send email reminders every morning at 06:00 WITA (Asia/Makassar)
Schedule::command('app:send-daily-reminders')
    ->dailyAt('06:00');
