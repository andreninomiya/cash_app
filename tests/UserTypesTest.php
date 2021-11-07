<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTypesTest extends TestCase
{
    public function testCreate()
    {
        $formData = [
            'description' => 'Teste',
        ];

        $response = $this->call('POST', '/user-types', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testUpdate()
    {
        $formData = [
            'description' => 'Teste2'
        ];

        $response = $this->call('PUT', '/user-types/1', $formData);

        $this->assertEquals(200, $response->status());
    }

    public function testShow()
    {
        $response = $this->call('GET', '/user-types/1');

        $this->assertEquals(200, $response->status());
    }

    public function testGetAll()
    {
        $response = $this->call('GET', '/user-types');

        $this->assertEquals(200, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/user-types/1');

        $this->assertEquals(200, $response->status());
    }
}
