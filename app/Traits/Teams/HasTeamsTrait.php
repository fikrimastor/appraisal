<?php

namespace App\Traits\Teams;

use Laravel\Jetstream\HasTeams;
use Laravel\Jetstream\OwnerRole;

trait HasTeamsTrait
{
    use HasTeams;

    /**
     * Get the role that the user has on the team.
     *
     * @param  mixed  $team
     * @return \Laravel\Jetstream\Role|null
     */
    public function teamRole($team)
    {
        if ($this->ownsTeam($team)) {
            return new OwnerRole;
        }

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
}
