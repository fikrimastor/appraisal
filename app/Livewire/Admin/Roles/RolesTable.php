<?php

namespace App\Livewire\Admin\Roles;

use App\Traits\Livewire\{AuthTrait, HasDatatableTrait};
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Role;

class RolesTable extends DataTableComponent
{
    use AuthTrait, HasDatatableTrait;

    protected $model = Role::class;

    public function builder(): Builder
    {
        parent::builder();
        return Role::query(); // Select some things
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("UUID", "uuid")
                ->hideIf(true),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Team", "team.name")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('components.livewire.datatables.action-column')->with(
                        [
                            'viewLink' => route('admin.roles.view', $row),
//                            'editLink' => route('users.edit', $row),
                            'deleteLink' => $this->user->can('delete', $row)
                                ? $row->id
                                : null,
                        ]
                    )
                )->html(),
        ];
    }

    public function confirmedDelete($data)
    {
        // Do something
        $role = Role::find($data['id']);
//        dump($role);

        $role->delete();
    }
}
