<?php

namespace App\Providers;

use App\Lib\Encryptor\EncryptorInterface;
use App\Lib\Encryptor\LaravelEncryptor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
