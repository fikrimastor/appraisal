<?php

namespace App\Livewire\Teams\Roles;

use App\Traits\Livewire\TeamsTrait;
use Livewire\Component;

class PermissionRoleManagement extends Component
{
    use TeamsTrait;

    public function render()
    {
        return view('livewire.teams.roles.permission-role-management');
    }
}
