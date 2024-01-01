<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Actions\Fortify\CreateNewUser;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Role::create(['name' => 'Super Admin']);

        $users = [
            [
                'name' => 'Super User',
                'email' => 'super@admin.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'terms' => 1,
//                'super_admin' => 1,
            ],
            [
                'name' => 'Karim Benzema',
                'email' => 'karim@email.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'terms' => 1,
            ],
            [
                'name' => 'John Doe',
                'email' => 'joohn@email.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'terms' => 1,
            ]
        ];

        collect($users)->each(fn ($user) => (new CreateNewUser())->create($user));

        $permissions = [
            'teams.view',
            'teams.create',
            'teams.manage',
            'teams.update',
            'teams.delete',
            'roles.view',
            'roles.create',
            'roles.manage',
            'roles.update',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.manage',
            'permissions.update',
            'permissions.delete',
        ];

        collect($permissions)->each(fn ($permission) => \App\Models\Permission::create(['name' => $permission]));

        $superAdmin = \App\Models\User::first();

        $currentTeam = $superAdmin->currentTeam;

        $currentTeamRole = Role::firstOrCreate([
            'name' => 'Admin',
            'description' => 'Admin of the team',
            'team_id' => $currentTeam->id,
        ]);

        setPermissionsTeamId($currentTeam);
        $currentTeam->assignRole($currentTeamRole);

        $currentTeamRole->givePermissionTo(\App\Models\Permission::get()->pluck('name')->toArray());

        $superAdminTeam = $superAdmin->ownedTeams()->create([
            'name' => 'Super Admin Team',
            'personal_team' => false,
        ]);

        $superAdmin->assignSuperAdmin($superAdminTeam);
    }
}
