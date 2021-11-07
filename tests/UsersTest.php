<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    public function testCreate()
    {
        $formData = [
            'first_name' => 'Usuário',
            'last_name' => 'Teste',
            'cpf_cnpj' => '25131353858',
            'email' => 'teste@gmail.com',
            'password' => 'Teste123',
            'fk_type' => 1,
        ];

        $response = $this->call('POST', '/users', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdate()
    {
        $formData = [
            'last_name' => 'Teste'
        ];

        $response = $this->call('PUT', '/users/1', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testShow()
    {
        $response = $this->call('GET', '/users/1');

        $this->assertEquals(200, $response->status());
    }

    public function testGetAll()
    {
        $response = $this->call('GET', '/users');

        $this->assertEquals(200, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/users/1');

        $this->assertEquals(200, $response->status());
    }
}
