<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'User',
            'Recipe',
            'Level',
            'Category',
        ];

        foreach ($models as $model) {
            $this->app->singleton(
                "App\Constracts\Eloquent\\{$model}Repository",
                "App\Repositories\Eloquent\\{$model}RepositoryEloquent"
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
