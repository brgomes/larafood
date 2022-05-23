<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProfile;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $repository;

    public function __construct(Profile $profile)
    {
        $this->middleware('can:profiles');
        $this->repository = $profile;
    }

    public function index()
    {
        $profiles = $this->repository->paginate();

        return view('admin.pages.profiles.index', compact('profiles'));
    }

    public function search(Request $request)
    {
        $filters = $request->only('name');
        $profiles = $this->repository->search($request->filter);

        return view('admin.pages.profiles.index', [
            'filters' => $filters,
            'profiles' => $profiles,
        ]);
    }

    public function show(Profile $profile)
    {
        return view('admin.pages.profiles.show', compact('profile'));
    }

    public function create()
    {
        return view('admin.pages.profiles.create');
    }

    public function store(StoreUpdateProfile $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('profiles.index');
    }

    public function edit(Profile $profile)
    {
        return view('admin.pages.profiles.edit', compact('profile'));
    }

    public function update(StoreUpdateProfile $request, Profile $profile)
    {
        $profile->update($request->all());

        return redirect()->route('profiles.index');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('profiles.index');
    }
}
