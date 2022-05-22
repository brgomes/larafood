@extends('adminlte::page')

@section('title', "Editar Produto {$product->title}")

@section('content_header')
    <h1>Editar Produto <b>{{ $product->title }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST" class="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.pages.products._partials.form')
            </form>
        </div>
    </div>
@stop
