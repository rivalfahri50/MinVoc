<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'code' => Str::uuid(),
            'avatar' => 'images/default.png',
            'deskripsi' => 'none',
            'name' => 'admin',
            'is_login' => false,
            'role_id' => 4,
            'email' => 'untukprojects123@gmail.com',
            'password' => '$2y$10$eSfmaLKIg86V0xg2R1pVP.BKIusL1PRv48mxqFq5LZeImpgpul30i',
        ]);

        admin::create([
            'user_id' => 1,
            'name' => 'admin',
            'email' => 'untukprojects123@gmail.com',
            'password' => '$2y$10$eSfmaLKIg86V0xg2R1pVP.BKIusL1PRv48mxqFq5LZeImpgpul30i',
        ]);
    }
}
