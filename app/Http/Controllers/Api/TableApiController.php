<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\TableResource;
use App\Services\TableService;

class TableApiController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function tablesByTenant(TenantFormRequest $request)
    {
        $tables = $this->tableService->tablesByTenantUuid($request->token_company);

        return TableResource::collection($tables);
    }

    public function show(TenantFormRequest $request, $identify)
    {
        if (!$table = $this->tableService->tableByIdentify($identify)) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        return new TableResource($table);
    }
}
