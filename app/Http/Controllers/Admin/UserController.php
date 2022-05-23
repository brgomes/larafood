<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repository;

    public function __construct(User $user)
    {
        $this->middleware('can:users');
        $this->repository = $user;
    }

    public function index()
    {
        $users = $this->repository->tenantUser()->paginate();

        return view('admin.pages.users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $users = $this->repository->where(function ($query) use ($request) {
            if ($request->filter) {
                $query->where('name', 'LIKE', "%{$request->filter}%")
                    ->orWhere('email', $request->filter);
            }
        })->paginate();

        return view('admin.pages.users.index', [
            'filters' => $filters,
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        return view('admin.pages.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(StoreUpdateUser $request)
    {
        $data = $request->all();

        $data['tenant_id'] = auth()->user()->tenant_id;
        $data['password'] = bcrypt($data['password']);

        $this->repository->create($data);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(StoreUpdateUser $request, User $user)
    {
        $data = $request->only(['name', 'email']);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
