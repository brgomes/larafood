<?php

namespace App\Tenant;

use App\Models\Tenant;

class ManagerTenant
{
    public function getTenantIdentify(): ?int
    {
        return auth()->check() ? auth()->user()->tenant_id : null;
    }

    public function getTenant(): ?Tenant
    {
        return auth()->check() ? auth()->user()->tenant : null;
    }

    public function isAdmin(): bool
    {
        return in_array(auth()->user()->email, config('tenant.admins'));
    }
}
