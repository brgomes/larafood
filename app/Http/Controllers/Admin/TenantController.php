<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    protected $repository;

    public function __construct(Tenant $tenant)
    {
        $this->repository = $tenant;
        $this->middleware('can:tenants');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = $this->repository->latest()->paginate();

        return view('admin.pages.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTenant $request)
    {
        $data = $request->all();
        $tenant = auth()->user()->tenant;

        if ($request->hasFile('logo') && $request->logo->isValid()) {
            $data['logo'] = $request->logo->store("tenants/{$tenant->uuid}");
        }

        $this->repository->create($data);

        return redirect()->route('tenants.index');
    }

    public function show(Tenant $tenant)
    {
        return view('admin.pages.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.pages.tenants.edit', compact('tenant'));
    }

    public function update(StoreUpdateTenant $request, Tenant $tenant)
    {
        $data = $request->all();
        $tenant = auth()->user()->tenant;

        if ($request->hasFile('logo') && $request->logo->isValid()) {
            if (Storage::exists($tenant->logo)) {
                Storage::delete($tenant->logo);
            }

            $data['logo'] = $request->logo->store("tenants/{$tenant->uuid}");
        }

        $tenant->update($data);

        return redirect()->route('tenants.index');
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->logo && Storage::exists($tenant->logo)) {
            Storage::delete($tenant->logo);
        }

        $tenant->delete();

        return redirect()->route('tenants.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $tenants = $this->repository->where(function ($query) use ($request) {
            if ($request->filter) {
                $query->where('name', 'LIKE', "%{$request->filter}%");
            }
        })->paginate();

        return view('admin.pages.tenants.index', [
            'filters' => $filters,
            'tenants' => $tenants,
        ]);
    }
}
