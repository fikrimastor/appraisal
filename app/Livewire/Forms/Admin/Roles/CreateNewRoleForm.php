<?php

namespace App\Livewire\Forms\Admin\Roles;

use App\Models\Role;
use App\Models\Team;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateNewRoleForm extends Form
{
    public string $name = '';

    public string $description = '';

    public ?int $teamId;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'teamId' => ['required', 'exists:teams,id'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function submit(): array
    {
        $validated = $this->validate();

        $team = Team::findOrFail($this->teamId);

        $this->reset();

        $role = Role::updateOrCreate([
            'name' => $validated['name'],
            'team_id' => $team->id,
//            'guard_name' => config('auth.defaults.guard'),
        ], $validated);

        $team->assignRole($role);

        return $validated;
    }
}
