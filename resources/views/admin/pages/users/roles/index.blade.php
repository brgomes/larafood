@extends('adminlte::page')

@section('title', 'Cargos do Usuário ' . $user->name)

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item active"><a href="">Cargos</a></li>
    </ol>

    <h1>Cargos do Usuário <b>{{ $user->name }}</b></h1>
    <a href="{{ route('users.roles.create', $user) }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> ADD</a>
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
                    @foreach ($roles as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('users.roles.delete', [$user, $item]) }}" class="btn btn-danger">EXCLUIR</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $roles->appends($filters)->links() !!}
            @else
                {!! $roles->links() !!}
            @endif
        </div>
    </div>
@stop
