<?php

namespace App\Livewire\Admin\Roles;

use App\Livewire\Forms\Admin\Roles\AssignPermissionToRoleForm;
use App\Models\Role;
use App\Traits\Livewire\AuthTrait;
use App\Traits\Livewire\HasAlert;
use App\Traits\Livewire\PermissionRoleTrait;
use Livewire\Component;

class AssignPermissionToRole extends Component
{
    use AuthTrait, PermissionRoleTrait, HasAlert;

    public Role $role;

    public bool $selectAll = false;

    public AssignPermissionToRoleForm $form;


    public function mount()
    {
        $this->rolePermissions->each(function ($permission) {
            $this->form->permissionForRole[] = $permission->id;
        });
    }

    public function assignPermission()
    {
        $validated = $this->form->submit();

        $this->role->syncPermissions($validated);

        $this->onSuccessRedirectTo('Permission assigned successfully.!', 'admin.roles.list');
    }

    public function updatedSelectAll($value)
    {
        if ($this->selectAll) {
            foreach ($this->permissions as $key => $permission) {
                $this->form->permissionForRole[] = $permission->id;
            }
        } else {
            $this->form->permissionForRole = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.roles.assign-permission-to-role')->layout('layouts.app');
    }
}
