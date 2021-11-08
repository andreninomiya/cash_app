<?php

namespace Database\Seeders;

use App\Models\UserBalances;
use App\Models\UserBalancesHistorical;
use Illuminate\Database\Seeder;

class UserBalancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userBalance1 = UserBalances::create([
            'fk_user' => 1,
            'balance' => 600,
        ]);
        UserBalancesHistorical::create([
            'fk_user' => 1,
            'fk_balance' => $userBalance1->id,
            'balance' => 600,
        ]);

        $userBalance2 = UserBalances::create([
            'fk_user' => 2,
            'balance' => 1000,
        ]);
        UserBalancesHistorical::create([
            'fk_user' => 2,
            'fk_balance' => $userBalance2->id,
            'balance' => 1000,
        ]);

        $userBalance3 = UserBalances::create([
            'fk_user' => 3,
            'balance' => 250,
        ]);
        UserBalancesHistorical::create([
            'fk_user' => 3,
            'fk_balance' => $userBalance3->id,
            'balance' => 250,
        ]);

        $userBalance4 = UserBalances::create([
            'fk_user' => 4,
            'balance' => 1500,
        ]);
        UserBalancesHistorical::create([
            'fk_user' => 4,
            'fk_balance' => $userBalance4->id,
            'balance' => 1500,
        ]);

        $userBalance5 = UserBalances::create([
            'fk_user' => 5,
            'balance' => 920,
        ]);
        UserBalancesHistorical::create([
            'fk_user' => 5,
            'fk_balance' => $userBalance5->id,
            'balance' => 920,
        ]);
    }
}
