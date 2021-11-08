<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionsTest extends TestCase
{
    public function testCreate()
    {
        $formData = [
            'payer' => 1,
            'payee' => 3,
            'value' => 250,
        ];

        $response = $this->call('POST', '/transactions', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdate()
    {
        $formData = [
            'value' => 100
        ];

        $response = $this->call('PUT', '/transactions/id/1', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testShow()
    {
        $response = $this->call('GET', '/transactions/id/1');

        $this->assertEquals(200, $response->status());
    }

    public function testGetAll()
    {
        $response = $this->call('GET', '/transactions');

        $this->assertEquals(200, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/transactions/id/1');

        $this->assertEquals(200, $response->status());
    }
}
