<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Account::create([
                'name' => 'Conta Principal',
                'type' => 'checking',
                'balance' => 0,
                'user_id' => $user->id
            ]);
        }
    }
} 