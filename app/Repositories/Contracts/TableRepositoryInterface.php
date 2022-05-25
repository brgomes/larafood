<?php

namespace App\Repositories\Contracts;

interface TableRepositoryInterface
{
    public function tablesByTenantUuid(string $uuid);
    public function tablesByTenantId(int $id);
    public function tableByIdentify(string $identify);
}
