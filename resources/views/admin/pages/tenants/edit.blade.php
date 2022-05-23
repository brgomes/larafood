@extends('adminlte::page')

@section('title', "Editar Empresa {$tenant->name}")

@section('content_header')
    <h1>Editar Empresa <b>{{ $tenant->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tenants.update', $tenant) }}" method="POST" class="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.pages.tenants._partials.form')
            </form>
        </div>
    </div>
@stop
