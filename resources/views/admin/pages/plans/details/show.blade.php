@extends('adminlte::page')

@section('title', "Detalhe do Plano {$plan->name}")

@section('content_header')
    <h1>Detalhe do Plano <b>{{ $plan->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome: </strong> {{ $detail->name }}
                </li>
            </ul>

            <form action="{{ route('details.plan.destroy', [$plan->url, $detail]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> EXCLUIR</button>
            </form>
        </div>
    </div>
@stop
