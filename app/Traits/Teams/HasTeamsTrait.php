<?php

namespace App\Traits\Teams;

use App\Models\Role;
use App\Models\Team;
use Illuminate\Support\Str;
use Laravel\Jetstream\HasTeams;
use Laravel\Jetstream\OwnerRole;
use Laravel\Sanctum\HasApiTokens;

trait HasTeamsTrait
{
    use HasTeams;

    /**
     * Get the role that the user has on the team.
     * @param $team
     * @return Role
     */
    public function teamRole($team)
    {
//        if ($this->ownsTeam($team)) {
//            return new OwnerRole;
//        }

        if (! $this->belongsToTeam($team)) {
            return;
        }

        return $team->users
            ->firstWhere('id', $this->id)
            ->membership
            ->memberRole;
    }

    /**
     * Determine if the user has the given role on the given team.
     *
     * @param  mixed  $team
     * @param  string  $role
     * @return bool
     */
    public function hasTeamRole($team, string $role)
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        return $this->belongsToTeam($team) && optional($team->users->firstWhere('id', $this->id)->membership->memberRole)->uuid === $role;
    }

    /**
     * Get the user's permissions for the given team.
     *
     * @param  mixed  $team
     * @return array
     */
    public function teamPermissions($team)
    {
        if ($this->ownsTeam($team)) {
            return ['*'];
        }

        if (! $this->belongsToTeam($team)) {
            return [];
        }

        return $this->teamRole($team)?->permissions->pluck('name')->toArray() ?? [];
    }

    /**
     * Assign super admin role to the team.
     *
     * @param  Team  $superAdminTeam
     * @return \App\Models\User
     */
    public function assignSuperAdmin(Team $superAdminTeam)
    {
        setPermissionsTeamId($superAdminTeam);
        // get the admin user and assign roles/permissions on new team model
        return $this->assignRole('Super Admin');
    }
}
