@extends('adminlte::page')

@section('title', "Detalhes da Empresa {$tenant->name}")

@section('content_header')
    <h1>Detalhes da Empresa <b>{{ $tenant->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('admin.includes.alerts')

            <img src="{{ asset("storage/{$tenant->logo}") }}">

            <ul>
                <li>
                    <strong>Plano: </strong> {{ $tenant->plan->name }}
                </li>
                <li>
                    <strong>Nome: </strong> {{ $tenant->name }}
                </li>
                <li>
                    <strong>URL: </strong> {{ $tenant->url }}
                </li>
                <li>
                    <strong>Email: </strong> {{ $tenant->email }}
                </li>
                <li>
                    <strong>CNPJ: </strong> {{ $tenant->cnpj }}
                </li>
                <li>
                    <strong>Ativo: </strong> {{ $tenant->active == 'Y' ? 'SIM' : 'NÃO' }}
                </li>
            </ul>

            <hr>
            <h3>Assinatura</h3>

            <ul>
                <li><strong>Data assinatura:</strong> {{ $tenant->subscription }}</li>
                <li><strong>Data expiração:</strong> {{ $tenant->expires_at }}</li>
                <li><strong>Identificador:</strong> {{ $tenant->subscription_id }}</li>
                <li><strong>Ativo:</strong> {{ $tenant->subscription_active == 'Y' ? 'SIM' : 'NÃO' }}</li>
            </ul>

            <form action="{{ route('tenants.destroy', $tenant) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> EXCLUIR</button>
            </form>
        </div>
    </div>
@stop
