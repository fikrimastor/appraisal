<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
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
        Relation::enforceMorphMap([
            'user' => \App\Models\User::class,
            'team' => \App\Models\Team::class,
            'membership' => \App\Models\Membership::class,
            'role' => \App\Models\Role::class,
            'permission' => \App\Models\Permission::class,
        ]);

//        setPermissionsTeamId(auth()->user()->currentTeam);
    }
}
