<?php

namespace App\Repositories;

use App\Repositories\Contracts\TableRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TableRepository implements TableRepositoryInterface
{
    protected $table;

    public function __construct()
    {
        $this->table = 'tables';
    }

    public function tablesByTenantUuid(string $uuid)
    {
        return DB::table($this->table)
            ->select('tables.*')
            ->join('tenants', 'tenants.id', '=', 'tables.tenant_id')
            ->where('tenants.uuid', $uuid)
            ->get();
    }

    public function tablesByTenantId(int $tenantId)
    {
        return DB::table($this->table)->where('tenant_id', $tenantId)->get();
    }

    public function tableByIdentify(string $identify)
    {
        return DB::table($this->table)->where('identifier', $identify)->first();
    }
}
