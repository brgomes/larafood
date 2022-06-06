<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testAuthValidation()
    {
        $response = $this->postJson('/api/v1/sanctum/token');

        $response->assertStatus(422);
    }

    public function testAuthWithFakeUser()
    {
        $payload = [
            'email' => 'bruno@opecsis.com.br',
            'password' => '12345678',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson('/api/v1/sanctum/token', $payload);

        $response->assertStatus(404)
            ->assertSimilarJson([
                'message' => trans('messages.invalid_credentials'),
            ]);
    }

    public function testAuthSuccess()
    {
        $client = factory(Client::class)->create();

        $payload = [
            'email' => $client->email,
            'password' => 'password',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson('/api/v1/sanctum/token', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testErrorGetMe()
    {
        $response = $this->getJson('/api/v1/auth/me');

        $response->assertStatus(401);
    }

    public function testGetMe()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $response = $this->getJson('/api/v1/auth/me', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    'name' => $client->name,
                    'email' => $client->email,
                ]
            ]);
    }

    public function testLogout()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $response = $this->getJson('/api/v1/auth/logout', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(204);
    }
}
