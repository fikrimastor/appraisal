<?php

namespace App\Livewire\Forms\Admin\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AssignPermissionToRoleForm extends Form
{
    public array $permissionForRole = [];

    public function rules()
    {
        return [
            'permissionForRole' => 'array',
            'permissionForRole.*' => 'exists:permissions,id',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function submit(): array
    {
        $validated = $this->validate();

        $permissions = Permission::get();
        $permissionsChanges = [];

        collect(array_unique($validated['permissionForRole']))->each(function ($permissionId) use ($permissions, &$permissionsChanges) {
            $permissions->contains(function ($value, $key) use ($permissionId, &$permissionsChanges) {
                if ($value['id'] === $permissionId) {
                    $permissionsChanges[] = $value['name'];
                }

            });
        });

        return $permissionsChanges;
    }
}
