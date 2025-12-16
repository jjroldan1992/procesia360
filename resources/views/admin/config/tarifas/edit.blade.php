@extends('layouts.admin')

@section('title', 'Editar Tarifa ' . $tarifa->anio)

@section('content')
    <div class="section-one-col">
        <div class="content-card">
            <h1 class="text-xl font-semibold mb-4">Editar Tarifa de Cuota (Año: {{ $tarifa->anio }})</h1>
            
            <form action="{{ route('config.tarifas.update', $tarifa) }}" method="POST">
                @method('PATCH')
                
                @include('admin.config.tarifas._form', ['tarifa' => $tarifa])

                <div class="form-actions mt-6">
                    <button type="submit" class="btn btn-primary">Actualizar Tarifa</button>
                    <a href="{{ route('config.tarifas.index') }}" class="btn btn-back">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection