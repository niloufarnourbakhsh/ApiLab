<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Gate::before(function ($user, $ability) {
//            return Permission::where('name', $ability)
//                ->whereHas('roles.users', function ($query) use ($user) {
//                    $query->where('users.id', $user->id);
//                })
//                ->exists() ? true : null;
//        });
//        app()->booted(function () {
//
//            if (! Schema::hasTable('permissions')) {
//                return;
//            }
//
        Permission::query()->with('roles')->each(function ($permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return !!$permission->roles->intersect($user->roles)->count();
            });
        });
    }
}
