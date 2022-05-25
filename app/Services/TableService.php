<?php

namespace App\Services;

use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TableService
{
    protected $tableRepository;
    protected $tenantRepository;

    public function __construct(
        TableRepositoryInterface $tableRepository,
        TenantRepositoryInterface $tenantRepository
    ) {
        $this->tableRepository = $tableRepository;
        $this->tenantRepository = $tenantRepository;
    }

    public function tablesByTenantUuid(string $uuid)
    {
        return $this->tableRepository->tablesByTenantUuid($uuid);
    }

    public function tableByIdentify(string $identify)
    {
        return $this->tableRepository->tableByIdentify($identify);
    }
}
