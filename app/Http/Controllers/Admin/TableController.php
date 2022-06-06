<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTable;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $repository;

    public function __construct(Table $table)
    {
        $this->repository = $table;
        $this->middleware('can:tables');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = $this->repository->latest()->paginate();

        return view('admin.pages.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTable $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('tables.index');
    }

    public function show(Table $table)
    {
        return view('admin.pages.tables.show', compact('table'));
    }

    public function qrcode($identify)
    {
        if (!$table = $this->repository->where('uuid', $identify)->first()) {
            return redirect()->back();
        }

        $tenant = auth()->user()->tenant;
        $uri = env('URI_CLIENT') . "/{$tenant->uuid}/{$table->uuid}";

        return view('admin.pages.tables.qrcode', compact('uri'));
    }

    public function edit(Table $table)
    {
        return view('admin.pages.tables.edit', compact('table'));
    }

    public function update(StoreUpdateTable $request, Table $table)
    {
        $table->update($request->all());

        return redirect()->route('tables.index');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $tables = $this->repository->where(function ($query) use ($request) {
            if ($request->filter) {
                $query->where('identify', 'LIKE', "%{$request->filter}%")
                    ->orWhere('description', 'LIKE', "%{$request->filter}%");
            }
        })->paginate();

        return view('admin.pages.tables.index', [
            'filters' => $filters,
            'tables' => $tables,
        ]);
    }
}
