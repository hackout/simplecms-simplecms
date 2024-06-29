<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

dynamic_require(__DIR__ . DIRECTORY_SEPARATOR . 'console');
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
