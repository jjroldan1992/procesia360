@extends('layouts.admin')

@section('title', 'Añadir Nuevo Hermano')

@section('content')

    {{-- El formulario apunta a la ruta 'censo.store' (POST /censo) --}}
    <form method="POST" action="{{ route('censo.store') }}">
        @csrf

        <div class="section-one-col">

                <div class="content-card">
                
                    <div class="card-header">
                        <h1>Crear Registro de Hermano</h1>
                        <a href="{{ route('censo.index') }}" class="btn btn-secondary">
                            ← Volver al Censo
                        </a>
                    </div>

                    {{-- Manejo de Errores de Validación --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input class="form-input" type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellidos:</label>
                        <input class="form-input" type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="dni">DNI/NIF:</label>
                        <input class="form-input" type="text" id="dni" name="dni" value="{{ old('dni') }}">
                    </div>

                    <div class="form-group">
                        <label for="domicilio_calle">Calle / Vía</label>
                        <input type="text" name="domicilio_calle" id="domicilio_calle" class="form-input" required>
                        @error('domicilio_calle')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                    <div class="form-group">
                        <label for="domicilio_numero">Número, Piso, Puerta</label>
                        <input type="text" name="domicilio_numero" id="domicilio_numero" class="form-input" required>
                        @error('domicilio_numero')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                
                    <div class="form-group">
                        <label for="domicilio_poblacion">Población / Municipio</label>
                        <input type="text" name="domicilio_poblacion" id="domicilio_poblacion" class="form-input" required>
                        @error('domicilio_poblacion')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                    <div class="form-group">
                        <label for="domicilio_cp">Código Postal</label>
                        <input type="text" name="domicilio_cp" id="domicilio_cp" class="form-input" required>
                        @error('domicilio_cp')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                    <div class="form-group">
                        <label for="domicilio_provincia">Provincia</label>
                        <input type="text" name="domicilio_provincia" id="domicilio_provincia" class="form-input"required>
                        @error('domicilio_provincia')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_alta">Fecha de Alta:</label>
                        <input class="form-input" type="date" id="fecha_alta" name="fecha_alta" value="{{ old('fecha_alta', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_alta">Fecha de Baja:</label>
                        <input class="form-input" type="date" id="fecha_alta" name="fecha_baja">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-submit" style="width:100%">
                            Guardar Hermano
                        </button>
                    </div>
                    
                </div> 
            
        </div>
    </form>
@endsection