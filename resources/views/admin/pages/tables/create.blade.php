@extends('adminlte::page')

@section('title', 'Cadastrar Nova Mesa')

@section('content_header')
    <h1>Cadastrar Nova Mesa</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tables.store') }}" method="POST" class="form">
                @csrf

                @include('admin.pages.tables._partials.form')
            </form>
        </div>
    </div>
@stop
