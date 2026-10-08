<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:seed-if-empty', function () {
    if (!Schema::hasTable('users') || DB::table('users')->count() > 0) {
        $this->info('Database terisi, seed dilewati.');

        return;
    }

    $this->call('db:seed');
})->purpose('Seed database hanya jika masih kosong (aman dipanggil tiap boot)');
