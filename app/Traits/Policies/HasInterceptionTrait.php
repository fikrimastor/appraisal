<?php

namespace App\Traits\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;

trait HasInterceptionTrait
{
    public function before(User $user): ?bool
    {
        // Check for super admin access
        setPermissionsTeamId($user->currentTeam);
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }
}
