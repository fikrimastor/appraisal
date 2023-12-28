<?php

namespace App\Livewire\Teams\Roles;

use App\Livewire\Forms\Teams\Roles\AddNewTeamRoleForm;
use App\Traits\Livewire\TeamsTrait;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AddNewRole extends Component
{
    use TeamsTrait;

    public AddNewTeamRoleForm $form;

    /**
     * @throws ValidationException
     */
    public function createNewRole()
    {
        $this->form->team = $this->team;
        $this->form->submit();

        $this->dispatch('roleAdded');
    }

    public function render()
    {
        return view('livewire.teams.roles.add-new-role');
    }
}
