<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function categoriesByTenantUuid(string $uuid);
    public function categoriesByTenantId(int $id);
    public function categoryByUuid(string $uuid);
}
