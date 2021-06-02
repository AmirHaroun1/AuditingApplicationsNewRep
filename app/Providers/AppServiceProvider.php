<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);
        // limit returning the balance to only your dashboard layout

        View::composer([
                'layout._Sidebar'
            ], function($view) {

                    $AuthUser = User::with('OfficeBranch')->findOrFail(Auth::id());


                view()->share('AuthUser', $AuthUser);
            });


    }
}
