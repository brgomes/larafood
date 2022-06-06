<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function testValidationCreateNewOrder()
    {
        $payload = [];
        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(422)
            ->assertJsonPath('errors.token_company', [
                trans('validation.required', ['attribute' => 'token company']), // Não pode passar underline
            ])
            ->assertJsonPath('errors.products', [
                trans('validation.required', ['attribute' => 'products']),
            ]);
    }

    public function testCreateNewOrder()
    {
        $tenant = factory(Tenant::class)->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
        ];

        $products = factory(Product::class, 10)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 2,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201);
    }

    public function testTotalOrder()
    {
        $tenant = factory(Tenant::class)->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
        ];

        $products = factory(Product::class, 2)->create([
            'price' => 9.9,
        ]);

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('data.total', 19.8);
    }

    public function testOrderNotFound()
    {
        $order = 'fake_value';
        $response = $this->getJson("/api/v1/orders/{$order}");

        $response->assertStatus(404);
    }

    public function testGetOrder()
    {
        $order = factory(Order::class)->create();
        $response = $this->getJson("/api/v1/orders/{$order->identify}");

        $response->assertStatus(200);
    }

    public function testCreateNewAuthenticatedOrder()
    {
        $tenant = factory(Tenant::class)->create();
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
        ];

        $products = factory(Product::class, 2)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 2,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(201);
    }

    public function testCreateNewOrderWithTable()
    {
        $table = factory(Table::class)->create();
        $tenant = factory(Tenant::class)->create();

        $payload = [
            'token_company' => $tenant->uuid,
            'table' => $table->uuid,
            'products' => [],
        ];

        $products = factory(Product::class, 2)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 2,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);
        //$response->dump();

        $response->assertStatus(201)
            //->assertJsonPath('data.table.uuid', $table->uuid)
            ->assertJsonPath('data.table.identify', $table->identify);
    }

    public function testGetMyOrders()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        factory(Order::class, 3)->create([
            'client_id' => $client->id,
        ]);

        $response = $this->getJson('/api/v1/auth/orders', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}
