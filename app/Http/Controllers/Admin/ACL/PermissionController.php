<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePermission;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(Permission $permission)
    {
        $this->repository = $permission;
    }

    public function index()
    {
        $permissions = $this->repository->paginate();

        return view('admin.pages.permissions.index', compact('permissions'));
    }

    public function search(Request $request)
    {
        $filters = $request->only('name');
        $permissions = $this->repository->search($request->filter);

        return view('admin.pages.permissions.index', [
            'filters' => $filters,
            'permissions' => $permissions,
        ]);
    }

    public function show(Permission $permission)
    {
        return view('admin.pages.permissions.show', compact('permission'));
    }

    public function create()
    {
        return view('admin.pages.permissions.create');
    }

    public function store(StoreUpdatePermission $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.pages.permissions.edit', compact('permission'));
    }

    public function update(StoreUpdatePermission $request, Permission $permission)
    {
        $permission->update($request->all());

        return redirect()->route('permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index');
    }
}
