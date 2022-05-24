@extends('adminlte::page')

@section('title', "Editar Cargo {$role->name}")

@section('content_header')
    <h1>Editar Cargo <b>{{ $role->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', $role) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                @include('admin.pages.roles._partials.form')
            </form>
        </div>
    </div>
@stop
