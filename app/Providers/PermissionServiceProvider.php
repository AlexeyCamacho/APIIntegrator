<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): bool
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user, $company = null) use ($permission) {
                    return $user->hasPermissionTo($permission, $company);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
        return false;
    }
}
