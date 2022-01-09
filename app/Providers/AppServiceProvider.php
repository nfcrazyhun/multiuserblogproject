<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
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
        //Prevent N+1 Queries by Disabling Them
        //https://www.youtube.com/watch?v=bLWYbyKcfYI
        Model::preventLazyLoading(! app()->isProduction());

        Gate::define('superadmin', function (User $user) {
            return $user->isSuperAdmin();
        });
    }
}
