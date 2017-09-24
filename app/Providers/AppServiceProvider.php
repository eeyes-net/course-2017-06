<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Eeyes\Common\EeyesCommon::config([
            'API_URL' => env('EEYES_API_URL', ''),
            'API_TOKEN' => env('EEYES_API_TOKEN', ''),
            'IMG_URL' => env('EEYES_IMG_URL', ''),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
