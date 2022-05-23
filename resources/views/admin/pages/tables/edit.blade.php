@extends('adminlte::page')

@section('title', "Editar Mesa {$table->identify}")

@section('content_header')
    <h1>Editar Mesa <b>{{ $table->identify }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tables.update', $table) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                @include('admin.pages.tables._partials.form')
            </form>
        </div>
    </div>
@stop
