<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'first_name' => 'André',
            'last_name' => 'Ninomiya',
            'cpf_cnpj' => '40959844813',
            'email' => 'andre.ninomiya@hotmail.com',
            'password' => '123456',
            'fk_type' => 1,
        ]);

        Users::create([
            'first_name' => 'Maria',
            'last_name' => 'Fernandes',
            'cpf_cnpj' => '45633729862',
            'email' => 'maria.fernandes@gmail.com',
            'password' => '654321',
            'fk_type' => 1,
        ]);

        Users::create([
            'first_name' => 'Bruno',
            'last_name' => 'Souza',
            'cpf_cnpj' => '88701355864',
            'email' => 'bruno.souza@gmail.com',
            'password' => '134679',
            'fk_type' => 1,
        ]);

        Users::create([
            'first_name' => 'Ana',
            'last_name' => 'Lima',
            'cpf_cnpj' => '10181775824',
            'email' => 'ana.lima@hotmail.com',
            'password' => '456789',
            'fk_type' => 2,
        ]);

        Users::create([
            'first_name' => 'Marcos',
            'last_name' => 'Pereira',
            'cpf_cnpj' => '42648112871',
            'email' => 'marcos.pereira@outlook.com',
            'password' => '789456',
            'fk_type' => 2,
        ]);
    }
}
