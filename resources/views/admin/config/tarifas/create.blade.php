@extends('layouts.admin')

@section('title', 'Crear Tarifa de Cuota')

@section('content')
    <div class="section-one-col">
        <div class="content-card">
            <h1 class="text-xl font-semibold mb-4">Añadir Nueva Tarifa de Cuota</h1>
            
            <form action="{{ route('config.tarifas.store') }}" method="POST">
                
                @include('admin.config.tarifas._form')

                <div class="form-actions mt-6">
                    <button type="submit" class="btn btn-primary">Guardar Tarifa</button>
                    <a href="{{ route('config.tarifas.index') }}" class="btn btn-back">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection