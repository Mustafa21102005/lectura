<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// To delete files in tmp folder
Schedule::command('uploads:clean-tmp')->everyMinute();

// To update the assignment statuses
Schedule::command('assignments:update-statuses')->everyMinute();

// To send assignment reminders
Schedule::command('assignments:send-reminders')->everyMinute();
