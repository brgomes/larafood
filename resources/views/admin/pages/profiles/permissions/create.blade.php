@extends('adminlte::page')

@section('title', 'Permissões Disponíveis para o Perfil ' . $profile->name)

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="">Perfis</a></li>
    </ol>

    <h1>
        Permissões Disponíveis para o Perfil <b>{{ $profile->name }}</b>
        <a href="{{ route('profiles.permissions.create', $profile) }}" class="btn btn-dark"><i class="fas fa-plus-square"></i> ADD</a>
    </h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('profiles.permissions.create', $profile) }}" method="POST" class="form form-inline">
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
                    <form action="{{ route('profiles.permissions.store', $profile) }}" method="post">
                        @csrf

                        @foreach ($permissions as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="permissions[]" value="{{ $item->id }}">
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
                {!! $permissions->appends($filters)->links() !!}
            @else
                {!! $permissions->links() !!}
            @endif
        </div>
    </div>
@stop
