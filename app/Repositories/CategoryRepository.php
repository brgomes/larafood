<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $table;

    public function __construct()
    {
        $this->table = 'categories';
    }

    public function categoriesByTenantUuid(string $uuid)
    {
        return DB::table($this->table)
            ->select('categories.*')
            ->join('tenants', 'tenants.id', '=', 'categories.tenant_id')
            ->where('tenants.uuid', $uuid)
            ->get();
    }

    public function categoriesByTenantId(int $tenantId)
    {
        return DB::table($this->table)->where('tenant_id', $tenantId)->get();
    }

    public function categoryByUrl(string $url)
    {
        return DB::table($this->table)->where('url', $url)->first();
    }
}
