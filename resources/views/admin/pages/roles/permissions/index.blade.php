@extends('adminlte::page')

@section('title', 'Permissões do Cargo ' . $role->name)

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="">Perfis</a></li>
    </ol>

    <h1>Permissões do Cargo <b>{{ $role->name }}</b></h1>
    <a href="{{ route('roles.permissions.create', $role) }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> ADD</a>
@stop

@section('content')
    <div class="card">
       <div class="card-body">
            @include('admin.includes.alerts')

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('roles.permissions.delete', [$role, $item]) }}" class="btn btn-danger">EXCLUIR</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $permissions->appends($filters)->links() !!}
            @else
                {!! $permissions->links() !!}
            @endif
        </div>
    </div>
@stop
