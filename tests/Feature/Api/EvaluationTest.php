<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Str;
use Tests\TestCase;

class EvaluationTest extends TestCase
{
    public function testErrorCreateNewEvaluation()
    {
        $order = 'fake_value';
        $response = $this->postJson("/api/v1/auth/orders/{$order}/evaluations");

        $response->assertStatus(401);
    }

    public function testCreateNewEvaluation()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;
        $order = $client->orders()->save(factory(Order::class)->make());
        $payload = [
            'stars' => 5,
            'comment' => 'Qualquer comentário',
        ];

        $headers = [
            'Authorization' => "Bearer {$token}",
        ];

        $response = $this->postJson("/api/v1/auth/orders/{$order->identify}/evaluations", $payload, $headers);
        //$response->dump();

        $response->assertStatus(201);
    }
}
