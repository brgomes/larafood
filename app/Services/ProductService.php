<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $tenantRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        TenantRepositoryInterface $tenantRepository
    ) {
        $this->productRepository = $productRepository;
        $this->tenantRepository = $tenantRepository;
    }

    public function productsByTenantUuid(string $uuid, array $categories)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $this->productRepository->productsByTenantId($tenant->id, $categories);
    }

    public function productByFlag(string $flag)
    {
        return $this->productRepository->productByFlag($flag);
    }
}
