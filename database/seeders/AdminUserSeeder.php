<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@onlifin.com.br'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Onl1f1n@2024'),
                'is_admin' => true,
            ]
        );
    }
} 