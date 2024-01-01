<?php

namespace App\Livewire\Admin\Modal;

use App\Livewire\Forms\Admin\Roles\CreateNewRoleForm;
use App\Models\Team;
use App\Traits\Livewire\HasAlert;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

class CreateNewRoleModal extends ModalComponent
{
    use HasAlert;

    public CreateNewRoleForm $form;

    public $searchTeam = 'Select Team';
    public $searchResults;

    public function mount()
    {
        $this->searchResults = Team::get();
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

        $this->dispatch('refreshDatatable');
        $this->onSuccess('Role created!');
        $this->closeModal();
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render()
    {
        return view('livewire.admin.modal.create-new-role-modal');
    }
}
