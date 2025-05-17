<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'root',
            'email' => 'root@example.com',
            'password' => '123456', // Always hash passwords
            'active' => 1,
        ]);

        for($i = 1 ; $i < 21 ; $i++){
            User::query()->create([
                'name' => 'root' . $i,
                'email' => 'root' . $i . '@example.com',
                'password' => '123456', // Always hash passwords
                'active' => ($i > 10) ? 0 : 1,
            ]);
        }
    }
}
