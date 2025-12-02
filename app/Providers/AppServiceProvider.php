<?php

namespace App\Providers;

// 1. PASTIKAN BARIS INI ADA DI SINI (Di luar class, di bawah namespace)
use Illuminate\Pagination\Paginator;
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
        // 2. Baru panggil di sini
        Paginator::useTailwind();
    }
}
