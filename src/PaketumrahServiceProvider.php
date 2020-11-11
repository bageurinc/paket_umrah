<?php

namespace Bageur\PaketUmrah;

use Illuminate\Support\ServiceProvider;

class PaketumrahServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // include __DIR__.'/routes/web.php';
        $this->app->make('Bageur\PaketUmrah\PaketController');
        $this->app->make('Bageur\PaketUmrah\JadwalController');
        $this->app->make('Bageur\PaketUmrah\JadwalfotoController');
        $this->app->make('Bageur\PaketUmrah\HotelController');
        // $this->app->make('Bageur\PaketUmrah\KategoriController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migration');
    }
}
