<?php

namespace App\Traits\Teams;

use Illuminate\Support\Collection;

trait TeamRolePermissionTrait
{
    /**
     * @throws \Exception
     */
    public function getTeamRolesProperty(): Collection
    {
        $this->checkTeamExistance();

        return $this->team->roles;
    }
}
