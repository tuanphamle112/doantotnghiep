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
            $user = Auth::user();
            $dataNoti = [];
            $notifications = $user->notifications()->paginate(10);
            $unreadNotifications = $user->unreadNotifications;
            $unreadNotificationsNum = count($unreadNotifications);
            $dataNoti['notifications'] = $notifications;
            $dataNoti['unreadNum'] = $unreadNotificationsNum;
            
            $view->with('dataNoti', $dataNoti);
        });
    }
}
