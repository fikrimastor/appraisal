<?php

namespace App\Livewire\Teams\Roles;

use App\Livewire\Forms\Teams\Roles\AddNewTeamRoleForm;
use App\Traits\Livewire\PermissionRoleTrait;
use App\Traits\Livewire\TeamsTrait;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AddNewRole extends Component
{
    use TeamsTrait, PermissionRoleTrait;

    public AddNewTeamRoleForm $form;

    public bool $currentlyManagingPermission = false;


    /**
     * @throws ValidationException
     */
    public function createNewRole()
    {
        $this->form->team = $this->team;
        $this->form->submit();

        $this->dispatch('roleAdded');
    }

    public function managePermissions($roleUuid)
    {
        $this->currentlyManagingPermission = true;
        $this->roleUuid = $roleUuid;
    }

    public function stopManagingPermissions()
    {
        $this->currentlyManagingPermission = false;
    }

    public function updatePermissions()
    {
//        $this->role->permissions()->sync($this->form->permissions);
//        $this->dispatch('roleUpdated');
        $this->stopManagingPermissions();
    }

    public function render()
    {
        return view('livewire.teams.roles.add-new-role');
    }
}
