<?php

namespace App\Livewire\Forms\Teams;

use App\Models\Team;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddTeamMemberForm extends Form
{
    public string $email = '';

    public string $role = '';

    public function rules(): array
    {
//        dd($this->role);
        return [
            'email' => ['required', 'string', 'max:255'],
//            'role' => ['nullable', 'string', 'exists:App\Models\Role,uuid'],
            'role' => ['nullable', 'string', Rule::exists('roles', 'uuid')],
//            'roleUuid' => ['nullable', 'string', Rule::exists('roles', 'uuid')],
////            'role' => ['nullable', Rule::exists('roles')->where('uuid', '=', $this->role),],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function submit(): array
    {//dd($this->role);
        $validated = $this->validate();

        $this->reset();

        return $validated;
    }
}
