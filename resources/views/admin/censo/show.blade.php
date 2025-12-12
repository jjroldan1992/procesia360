@extends('layouts.admin')

@section('title', 'Ficha de Hermano')

@section('content')

<div class="section-one-col">

    <div class="content-card">

        <div class="card-header">
            <h1>{{ $hermano->nombre }} {{ $hermano->apellido }}</h1>
            
            <div class="actions">
                <a href="{{ route('censo.index') }}" class="btn btn-secondary">
                    ← Volver al Censo
                </a>
                <a href="{{ route('censo.edit', $hermano) }}" class="btn btn-primary">
                    Editar Ficha
                </a>
            </div>

        </div>
    </div>

</div>

<div class="section-four-cols">

    <div class="content-card">
        <h3>Datos personales</h3>
        <p><strong>Número de Hermano:</strong> {{ $hermano->numero_hermano }}</p>
        <p><strong>DNI/NIF:</strong> {{ $hermano->dni }}</p>
        <p><strong>Domicilio:</strong> {{ $hermano->domicilio_calle }}, {{ $hermano->domicilio_numero }} {{ $hermano->domicilio_cp }} {{ $hermano->domicilio_poblacion }} ({{ $hermano->domicilio_provincia }})</p>
    </div>

    <div class="content-card">
        <h3>Antigüedad</h3>
        <p><strong>Fecha de Alta:</strong> {{ $hermano->fecha_alta->format('d/m/Y') }}</p>
        <p><strong>Antigüedad Total:</strong> {{ $hermano->fecha_alta->diff(Carbon\Carbon::now())->format('%y años, %m meses y %d días') }}</p>
        @if($hermano->fecha_baja != null)<p><strong>Fecha de Baja:</strong> {{ $hermano->fecha_baja->format('d/m/Y') }}</p>@endif
        
    </div>

    <div class="content-card">
        <h3>Recibos</h3>
        <p><strong>Al corriente de pago:</strong> Sí (por desarrollar)</p>
        <p><strong>Próximo recibo</strong> 2026 (por desarrollar)</p>
    </div>

    <div class="content-card">
        <h3>Cuenta de Acceso (Usuario)</h3>
            @if ($hermano->usuario)
                <p>Este hermano tiene una cuenta de usuario activa:</p>
                <ul>
                    <li><strong>Email:</strong> {{ $hermano->usuario->email }}</li>
                    <li><strong>Rol:</strong> {{ $hermano->usuario->rol->nombre }}</li>
                </ul>
            @else
                <p><a href="#" class="btn btn-secondary">Crear usuario</a></p>
            @endif
    </div>
</div>

<div class="section-two-cols">

    <div class="content-card">
        <h3>Histórico</h3>
        <div class="history-list">
            @foreach($hermano->numerosHistorico as $historial)
                <div class="history-item">
                    <span class="history-number"><b>Nº {{ $historial->numero_obtenido }}</b></span>
                    <span class="history-date">Asignado el <b>{{ $historial->fecha_asignacion->translatedFormat('j \d\e F \d\e Y') }}</b></span>
                    <span class="history-motive"> - {{ $historial->motivo }}</span>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection