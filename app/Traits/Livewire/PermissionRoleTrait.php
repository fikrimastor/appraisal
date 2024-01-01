<?php

namespace App\Traits\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;

trait PermissionRoleTrait
{
    public $roleUuid;

    public function getRoleProperty(): Role
    {
        return Role::firstWhere('uuid', $this->roleUuid);
    }

    public function getPermissionsProperty(): Collection
    {
        return Permission::get()->sortBy('name');
    }

    public function getRolePermissionsProperty(): Collection
    {
        return $this->role->permissions;
    }
}
