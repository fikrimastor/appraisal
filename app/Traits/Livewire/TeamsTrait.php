<?php

namespace App\Traits\Livewire;

use App\Traits\Teams\TeamRolePermissionTrait;

trait TeamsTrait
{
    use TeamRolePermissionTrait;

    public $team;

    /**
     * @throws \Exception
     */
    public function checkTeamExistance(): void
    {
        if (is_null($this->team)) {
            throw new \Exception('Error: Team not found.');
        }
    }
}
