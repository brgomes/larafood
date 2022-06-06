@extends('adminlte::page')

@section('title', 'Mesas')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tables.index') }}">Mesas</a></li>
    </ol>

    <h1>Mesas <a href="{{ route('tables.create') }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> ADD</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('tables.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Nome" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">Filtrar</button>
            </form>
        </div>
        <div class="card-body">
            @include('admin.includes.alerts')

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $item)
                        <tr>
                            <td>{{ $item->identify }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <a href="{{ route('tables.qrcode', $item->uuid) }}" class="btn btn-primary" title="QRcode" target="_blank"><i class="fas fa-qrcode"></i></a>
                                <a href="{{ route('tables.edit', $item) }}" class="btn btn-info">EDITAR</a>
                                <a href="{{ route('tables.show', $item) }}" class="btn btn-warning">VER</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $tables->appends($filters)->links() !!}
            @else
                {!! $tables->links() !!}
            @endif
        </div>
    </div>
@stop
