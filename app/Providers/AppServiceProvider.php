<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            $unreadCount = DB::table('notifikasi')
                ->where('status_baca', 'belum')
                ->count();

            $view->with('unreadCount', $unreadCount);
        });
    }
}