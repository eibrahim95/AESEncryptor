<?php

namespace App\Providers;

use App\Lib\Encryptor\EncryptorInterface;
use App\Lib\Encryptor\LaravelEncryptor;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class EncryptorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EncryptorInterface::class, LaravelEncryptor::class);
    }
}
