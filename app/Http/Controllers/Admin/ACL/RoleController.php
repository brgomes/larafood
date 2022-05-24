<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRole;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(Role $role)
    {
        $this->middleware('can:roles');
        $this->repository = $role;
    }

    public function index()
    {
        $roles = $this->repository->paginate();

        return view('admin.pages.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        return view('admin.pages.roles.show', compact('role'));
    }

    public function create()
    {
        return view('admin.pages.roles.create');
    }

    public function store(StoreUpdateRole $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        return view('admin.pages.roles.edit', compact('role'));
    }

    public function update(StoreUpdateRole $request, Role $role)
    {
        $role->update($request->all());

        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $roles = $this->repository->where(function ($query) use ($request) {
            if ($request->filter) {
                $query->where('name', 'LIKE', "%{$request->filter}%")
                    ->orWhere('description', 'LIKE', "%{$request->filter}%");
            }
        })->paginate();

        return view('admin.pages.roles.index', [
            'filters' => $filters,
            'roles' => $roles,
        ]);
    }
}
