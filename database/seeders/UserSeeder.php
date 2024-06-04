<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory(20)->create()->each(function ($user) {
            $accountsCount = rand(1, 2);

            Account::factory($accountsCount)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
