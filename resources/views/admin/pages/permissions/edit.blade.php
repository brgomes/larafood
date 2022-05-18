@extends('adminlte::page')

@section('title', "Editar Permissão {$permission->name}")

@section('content_header')
    <h1>Editar Permissão <b>{{ $permission->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissions.update', $permission) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                @include('admin.pages.permissions._partials.form')
            </form>
        </div>
    </div>
@stop
