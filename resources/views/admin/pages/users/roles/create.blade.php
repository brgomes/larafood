@extends('adminlte::page')

@section('title', 'Cargos Disponíveis para o Usuário ' . $user->name)

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
        <li class="breadcrumb-item active"><a href="">Cargos</a></li>
    </ol>

    <h1>
        Cargos Disponíveis para o Usuário <b>{{ $user->name }}</b>
        <a href="{{ route('users.roles.create', $user) }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> ADD</a>
    </h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('users.roles.create', $user) }}" method="POST" class="form form-inline">
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
                        <th width="50px">#</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="{{ route('users.roles.store', $user) }}" method="post">
                        @csrf

                        @foreach ($roles as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="roles[]" value="{{ $item->id }}">
                                </td>
                                <td>{{ $item->name }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="2">
                                <button type="submit" class="btn btn-success">Vincular</button>
                            </td>
                        </tr>
                    </form>
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
