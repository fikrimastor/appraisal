<?php

namespace App\Livewire\Forms\Teams\Roles;

use App\Models\Role;
use App\Models\Team;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddNewTeamRoleForm extends Form
{
    public Team $team;

    public string $name = '';

    public string $description = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'max:255'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function submit(): Role
    {
        $this->validate();

        $role = $this->team->roles()->firstOrCreate([
            'name' => $this->name,
            'description' => $this->description,
        ]);


        $this->reset('name', 'description');

        return $role;
    }
}
