<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

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
        view()->composer('frontend.layouts.master', function ($view) {
            $dataNoti = [];
            if (Auth::check()) {
                $user = Auth::user();

                $notifications = $user->notifications()->paginate(5);
                $unreadNotifications = $user->unreadNotifications;
                $unreadNotificationsNum = count($unreadNotifications);
                $dataNoti['notifications'] = $notifications;
                $dataNoti['unreadNum'] = $unreadNotificationsNum;
            }

            $view->with('dataNoti', $dataNoti);
        });
    }
}
