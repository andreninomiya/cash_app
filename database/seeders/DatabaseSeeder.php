<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UserTypesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UserBalancesSeeder::class);
        Model::reguard();
    }
}
