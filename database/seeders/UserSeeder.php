<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        User::factory()->admin()->create([
            'username' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);

        //others
        User::factory()->count(5)->create();
    }
}
