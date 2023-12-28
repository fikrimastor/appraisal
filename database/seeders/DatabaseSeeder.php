<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Actions\Fortify\CreateNewUser;
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

        $users = [
            [
                'name' => 'Super User',
                'email' => 'super@email.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'terms' => 1,
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
    }
}
