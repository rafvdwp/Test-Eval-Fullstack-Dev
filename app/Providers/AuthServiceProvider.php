<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('assign-tasks', function (User $user, User $assignee) {
            // Admin bisa assign ke siapa saja, Manager hanya ke staff
            if ($user->role === 'admin') return true;
            if ($user->role === 'manager' && $assignee->role === 'staff') return true;
            return false;
        });

        Gate::define('viewLogs', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
