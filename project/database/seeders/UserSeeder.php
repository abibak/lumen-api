<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(15)->create(['points' => 0, 'password' => 'test']);
        User::factory(1)->create([
            'points' => 0,
            'password' => 'admin',
            'email' => 'admin@mail.ru',
            'is_admin' => true,
        ]);
    }
}
