<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Component;

class RoleManagement extends Component
{
    public function getListeners()
    {
        return [
            'refreshRoleManagement' => 'refreshDatatable',
        ];
    }

    public function createRole()
    {
//        $this->dispatch('openModal', 'admin.modal.create-new-role-modal');
        return to_route('admin.roles.create');
    }

    public function render()
    {
        return view('livewire.admin.roles.role-management')->layout('layouts.app');
    }
}
