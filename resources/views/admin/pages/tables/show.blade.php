@extends('adminlte::page')

@section('title', "Detalhes da Mesa {$table->identify}")

@section('content_header')
    <h1>Detalhes da Mesa <b>{{ $table->identify }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')

            <ul>
                <li>
                    <strong>Identificador: </strong> {{ $table->identify }}
                </li>
                <li>
                    <strong>Descrição: </strong> {{ $table->description }}
                </li>
            </ul>

            <form action="{{ route('tables.destroy', $table) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> EXCLUIR</button>
            </form>
        </div>
    </div>
@stop
