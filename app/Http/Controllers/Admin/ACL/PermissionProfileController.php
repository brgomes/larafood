<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;

class PermissionProfileController extends Controller
{
    protected $profile;
    protected $permission;

    public function __construct(Profile $profile, Permission $permission)
    {
        $this->profile = $profile;
        $this->permission = $permission;
    }

    public function index(Profile $profile)
    {
        $permissions = $profile->permissions()->paginate();

        return view('admin.pages.profiles.permissions.index', compact('profile', 'permissions'));
    }

    public function profiles(Permission $permission)
    {
        $profiles = $permission->profiles()->paginate();

        return view('admin.pages.permissions.profiles', compact('permission', 'profiles'));
    }

    public function create(Request $request, Profile $profile)
    {
        $filters = $request->except('_token');
        $permissions = $profile->permissionsAvailable($request->filter);

        return view('admin.pages.profiles.permissions.create', compact('profile', 'permissions', 'filters'));
    }

    public function store(Request $request, Profile $profile)
    {
        $data = $request->permissions ?: [];

        if (count($data) == 0) {
            return redirect()->back()->with('warning', 'Selecione uma permissão.');
        }

        $profile->permissions()->attach($data);

        return redirect()->route('profiles.permissions', $profile);
    }

    public function delete(Profile $profile, Permission $permission)
    {
        $profile->permissions()->detach($permission);

        return redirect()->route('profiles.permissions', $profile);
    }
}
