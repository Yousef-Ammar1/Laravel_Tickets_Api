<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        Ticket::factory(100)->recycle($users)->create();

        User::create([
            'email' => 'manager@manager.com',
            'password' => bcrypt('password'),
            'name' => 'The Manager',
            'is_maneger' => true,
        ]);
        /*
        In the context of Laravel's factories, the recycle method is used to assign existing models
        to the factory instead of creating new ones each time.
        This is particularly useful when you want to associate multiple records with a
        limited set of existing models.
        */

    }
}
