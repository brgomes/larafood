@extends('adminlte::page')

@section('title', "Categorias do produto {$product->title}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.show', $product) }}">Produto</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.categories', $product) }}" class="active">Categorias</a></li>
    </ol>

    <h1>Categorias do produto <strong>{{ $product->title }}</strong></h1>

    <a href="{{ route('products.categories.create', $product) }}" class="btn btn-dark">ADD NOVA CATEGORIA</a>

@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="50">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                        <tr>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('products.categories.delete', [$product, $item]) }}" class="btn btn-danger">DESVINCULAR</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $categories->appends($filters)->links() !!}
            @else
                {!! $categories->links() !!}
            @endif
        </div>
    </div>
@stop
