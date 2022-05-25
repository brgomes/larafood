<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;
    protected $tenantRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        TenantRepositoryInterface $tenantRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->tenantRepository = $tenantRepository;
    }

    public function categoriesByTenantUuid(string $uuid)
    {
        return $this->categoryRepository->categoriesByTenantUuid($uuid);
    }

    public function categoryByUrl(string $url)
    {
        return $this->categoryRepository->categoryByUrl($url);
    }
}
