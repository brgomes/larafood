<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantApiController extends Controller
{
    protected $tentantService;

    public function __construct(TenantService $tentantService)
    {
        $this->tentantService = $tentantService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $tenants = $this->tentantService->getAllTenants($perPage);

        return TenantResource::collection($tenants);
    }

    public function show($uuid)
    {
        if (!$tenant = $this->tentantService->getTenantByUuid($uuid)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new TenantResource($tenant);
    }
}
