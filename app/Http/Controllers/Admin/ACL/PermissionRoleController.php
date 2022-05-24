<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    protected $role;
    protected $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->middleware('can:roles');
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index(Role $role)
    {
        $permissions = $role->permissions()->paginate();

        return view('admin.pages.roles.permissions.index', compact('role', 'permissions'));
    }

    public function roles(Permission $permission)
    {
        $roles = $permission->roles()->paginate();

        return view('admin.pages.permissions.roles', compact('permission', 'roles'));
    }

    public function create(Request $request, Role $role)
    {
        $filters = $request->except('_token');
        $permissions = $role->permissionsAvailable($request->filter);

        return view('admin.pages.roles.permissions.create', compact('role', 'permissions', 'filters'));
    }

    public function store(Request $request, Role $role)
    {
        $data = $request->permissions ?: [];

        if (count($data) == 0) {
            return redirect()->back()->with('warning', 'Selecione uma permissão.');
        }

        $role->permissions()->attach($data);

        return redirect()->route('roles.permissions', $role);
    }

    public function delete(Role $role, Permission $permission)
    {
        $role->permissions()->detach($permission);

        return redirect()->route('roles.permissions', $role);
    }
}
