@extends('adminlte::page')

@section('title', "Editar Usuário {$user->name}")

@section('content_header')
    <h1>Editar Usuário <b>{{ $user->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                @include('admin.pages.users._partials.form')
            </form>
        </div>
    </div>
@stop
