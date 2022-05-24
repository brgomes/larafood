<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->middleware('can:users');
        $this->user = $user;
        $this->role = $role;
    }

    public function index(User $user)
    {
        $roles = $user->roles()->paginate();

        return view('admin.pages.users.roles.index', compact('user', 'roles'));
    }

    public function users(Role $role)
    {
        $users = $role->users()->paginate();

        return view('admin.pages.roles.users', compact('role', 'users'));
    }

    public function create(Request $request, User $user)
    {
        $filters = $request->except('_token');
        $roles = $user->rolesAvailable($request->filter);

        return view('admin.pages.users.roles.create', compact('user', 'roles', 'filters'));
    }

    public function store(Request $request, User $user)
    {
        $data = $request->roles ?: [];

        if (count($data) == 0) {
            return redirect()->back()->with('warning', 'Selecione um cargo.');
        }

        $user->roles()->attach($data);

        return redirect()->route('users.roles', $user);
    }

    public function delete(User $user, Role $role)
    {
        $user->roles()->detach($role);

        return redirect()->route('users.roles', $user);
    }
}
