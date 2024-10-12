<?php

use App\Console\Commands\DeleteOldNotifications;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// don't delete it or I'll murder you :)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('astek:delete-old-notifications')->dailyAt('03:00');