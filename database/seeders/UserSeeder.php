<?php

namespace Database\Seeders;

use App\Models\Transfer;
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

            $accounts = Account::factory($accountsCount)->create([
                'user_id' => $user->id,
            ]);

            $allAccountIds = Account::pluck('id')->toArray();

            $accounts->each(function ($account) use ($allAccountIds, $accountsCount) {
                Transfer::factory($accountsCount)->create([
                    'sender_id' => $account->id,
                    'receiver_id' => $allAccountIds[array_rand($allAccountIds)],
                ]);
            });
        });
    }
}
