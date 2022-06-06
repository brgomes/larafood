<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testGetPasswordError()
    {
        $payload = [
            'email' => 'bruno@opecsis.com.br',
            'name' => 'OPECsis',
            //'password' => '12345678',
        ];

        $response = $this->postJson('/api/v1/client', $payload);
        //$response->dump();

        $response->assertStatus(422)
            ->assertSimilarJson([
                'errors' => [
                    'password' => [
                        __('validation.required', ['attribute' => 'password']),
                    ],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    public function testCreateNewClient()
    {
        $payload = [
            'email' => 'bruno@opecsis.com.br',
            'name' => 'OPECsis',
            'password' => '12345678',
        ];

        $response = $this->postJson('/api/v1/client', $payload);

        $response->assertStatus(201)
            ->assertSimilarJson([
                'data' => [
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                ]
            ]);
    }
}
