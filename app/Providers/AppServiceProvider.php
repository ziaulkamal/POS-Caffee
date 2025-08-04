<?php

namespace App\Providers;

use App\Models\Billing;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Atur locale Carbon ke bahasa Indonesia
        App::setLocale('id');
        Carbon::setLocale('id');

        View::composer('*', function ($view) {
            $today = Carbon::now('Asia/Jakarta')->toDateString(); // tanggal hari ini WIB

            $totalHariIni = Billing::where('status', 'sudah_bayar')
                ->whereDate('created_at', $today)
                ->sum('total_bayar');

            $view->with('tanggalHariIni', Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y'));
            $view->with('totalHariIni', $totalHariIni);
        });
    }
}
