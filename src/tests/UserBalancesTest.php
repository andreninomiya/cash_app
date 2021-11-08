<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserBalancesTest extends TestCase
{
    public function testCreate()
    {
        $formData = [
            'fk_user' => 1,
            'balance' => 999,
        ];

        $response = $this->call('POST', '/user-balances', $formData);

        $this->assertEquals(404, $response->status()); // Pois valida se um usuário já tem saldo criado
    }

    public function testUpdate()
    {
        $formData = [
            'balance' => 998
        ];

        $response = $this->call('PUT', '/user-balances/id/1', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testShow()
    {
        $response = $this->call('GET', '/user-balances/id/1');

        $this->assertEquals(200, $response->status());
    }

    public function testGetAll()
    {
        $response = $this->call('GET', '/user-balances');

        $this->assertEquals(200, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/user-balances/id/1');

        $this->assertEquals(200, $response->status());
    }

    public function testGetHistory()
    {
        $response = $this->call('GET', '/user-balances/history/balance/1');

        $this->assertEquals(200, $response->status());
    }
}
