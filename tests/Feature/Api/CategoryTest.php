<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Get all categories error
     *
     * @return void
     */
    public function testGetAllCategoriesError()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(422);
    }

    /**
     * Get all categories by tenant
     *
     * @return void
     */
    public function testGetAllCategoriesByTenant()
    {
        $tenant = factory(Tenant::class)->create();
        $response = $this->getJson("/api/v1/categories?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Error get category by tenant
     *
     * @return void
     */
    public function testErrorGetCategoriesByTenant()
    {
        $category = 'fake_value';
        $tenant = factory(Tenant::class)->create();
        $response = $this->getJson("/api/v1/categories/{$category}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * Get category by tenant
     *
     * @return void
     */
    public function testGetCategoriesByTenant()
    {
        $category = factory(Category::class)->create();
        $tenant = factory(Tenant::class)->create();
        $response = $this->getJson("/api/v1/categories/{$category->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
