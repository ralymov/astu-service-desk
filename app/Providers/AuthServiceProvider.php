<?php

namespace App\Providers;

use App\Models\Storage\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $isAdmin = static function (User $user) {
            return $user->isAdmin();
        };
        $isEmployee = static function (User $user) {
            return $user->isEmployee();
        };
        $isHead = static function (User $user) {
            return $user->isHead();
        };
        $isGuest = static function (User $user) {
            return $user->isGuest();
        };
        $isNotGuest = static function (User $user) {
            return !$user->isGuest();
        };
        $isAdminOrHead = static function (User $user) {
            return $user->isAdmin() || $user->isHead();
        };

        Gate::define('edit-references', $isAdmin);
        Gate::define('basic-permission', $isNotGuest);
        Gate::define('employee-permission', $isEmployee);
        Gate::define('guest-permission', $isGuest);
        Gate::define('head-permission', $isHead);
        Gate::define('admin-permission', $isAdmin);
    }
}
