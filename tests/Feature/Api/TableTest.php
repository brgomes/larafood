<?php

namespace Tests\Feature\Api;

use App\Models\Table;
use App\Models\Tenant;
use Tests\TestCase;

class TableTest extends TestCase
{
    /**
     * Get all tables error
     *
     * @return void
     */
    public function testGetAllTableError()
    {
        $response = $this->getJson('/api/v1/tables');

        $response->assertStatus(422);
    }

    /**
     * Get all tables by tenant
     *
     * @return void
     */
    public function testGetAllTableByTenant()
    {
        $tenant = factory(Tenant::class)->create();
        $response = $this->getJson("/api/v1/tables?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Error get category by tenant
     *
     * @return void
     */
    public function testErrorGetTableByTenant()
    {
        $table = 'fake_value';
        $tenant = factory(Tenant::class)->create();
        $response = $this->getJson("/api/v1/tables/{$table}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * Get category by tenant
     *
     * @return void
     */
    public function testGetTableByTenant()
    {
        $table = factory(Table::class)->create();
        $tenant = factory(Tenant::class)->create();
        $response = $this->getJson("/api/v1/tables/{$table->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
