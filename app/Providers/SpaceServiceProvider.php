<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator; 

class SpaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('spaceCheck', function ($attribute, $value, $parameters, $validator) {
            // dd($value);
            $strip = trim(mb_convert_kana($value, "s", 'UTF-8'));
            if (empty($strip)) {
                return false;
            }
            return true;
        });
    }
}
