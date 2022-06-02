<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function productsByTenantId(int $id, array $categories);
    public function productByUuid(string $uuid);
}
