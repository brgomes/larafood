<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class TenantService
{
    protected $plan;
    protected $data;
    protected $repository;

    public function __construct(TenantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTenants(int $perPage)
    {
        return $this->repository->getAllTenants($perPage);
    }

    public function getTenantByUuid($uuid)
    {
        return $this->repository->getTenantByUuid($uuid);
    }

    public function make(Plan $plan, array $data)
    {
        $this->plan = $plan;
        $this->data = $data;

        $tenant = $this->storeTenant();

        return $this->storeUser($tenant);
    }

    public function storeTenant()
    {
        return $this->plan->tenants()->create([
            'cnpj' => $this->data['cnpj'],
            'name' => $this->data['empresa'],
            'email' => $this->data['email'],
            'subscription' => now(),
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function storeUser(Tenant $tenant)
    {
        return $tenant->users()->create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => Hash::make($this->data['password']),
        ]);
    }
}
