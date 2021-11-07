<?php

namespace Database\Seeders;

use App\Models\UserTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserTypes::create([
            'description' => 'Usuário Comum'
        ]);

        UserTypes::create([
            'description' => 'Lojista'
        ]);
    }
}
