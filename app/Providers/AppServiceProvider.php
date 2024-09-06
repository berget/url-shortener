<?php

namespace App\Providers;

use App\Repositories\ShortUrlRepository;
use App\Repositories\ShortUrlRepositoryInterface;
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
        $this->app->bind(ShortUrlRepositoryInterface::class, ShortUrlRepository::class);
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
