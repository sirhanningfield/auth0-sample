<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;


use \Auth0\Login\Contract\Auth0UserRepository as Auth0Contract;
//use \App\Repositories\CustomUserRepository as UserRepo;
use Auth0\Login\Repository\Auth0UserRepository as UserRepo;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->format('c');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(
        Auth0Contract::class,
        UserRepo::class
      );
    }
}
