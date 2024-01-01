<?php

namespace App\Livewire\Admin\Roles;

use App\Livewire\Forms\Admin\Roles\CreateNewRoleForm;
use App\Models\Team;
use App\Traits\Livewire\HasAlert;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateNewRole extends Component
{
    use HasAlert;

    public CreateNewRoleForm $form;

    public $searchTeam = '';
    public $searchResults;

    public function mount()
    {
        $this->searchResults = Team::limit(5)->get();
    }

    public function updated()
    {
        $this->searchResults = Team::where('name', 'like', '%'.$this->searchTeam.'%')->get();
    }

    public function setTeam($team)
    {
        $this->form->teamId = $team['id'];
        $this->searchTeam = $team['name'];
    }

    /**
     * @throws ValidationException
     */
    public function createRole()
    {
        $this->form->submit();

//        $this->dispatch('refreshDatatable');
        $this->onSuccessRedirectTo('Role created!', 'admin.roles.list');
    }

    public function render()
    {
        return view('livewire.admin.roles.create-new-role')->layout('layouts.app');
    }
}
