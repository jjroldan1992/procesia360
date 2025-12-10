@extends('layouts.admin') {{-- Asumimos que más adelante crearás una plantilla base llamada 'layouts.admin' --}}

@section('title', 'Censo de Hermanos')

@section('content')
    <div class="header">
        <h1>Censo de Hermanos</h1>
        <a href="{{ route('censo.create') }}" class="btn-primary">
            + Añadir Nuevo Hermano
        </a>
    </div>

    @if($hermanos->isEmpty())
        <p>No hay hermanos registrados en el censo.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>DNI</th>
                    <th>Fecha de Alta</th>
                    <th>Antigüedad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hermanos as $hermano)
                    <tr>
                        <td>{{ $hermano->id }}</td>
                        <td>{{ $hermano->nombre }} {{ $hermano->apellido }}</td>
                        <td>{{ $hermano->dni }}</td>
                        <td>{{ $hermano->fecha_alta->format('d/m/Y') }}</td>
                        <td>{{ $hermano->fecha_alta->diffInYears(\Carbon\Carbon::now()) }} años</td>
                        <td>
                            <a href="{{ route('censo.show', $hermano) }}">Ver</a> | 
                            <a href="{{ route('censo.edit', $hermano) }}">Editar</a> | 
                            <form action="{{ route('censo.destroy', $hermano) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE') {{-- Esto le dice a Laravel que es una petición DELETE --}}
                                <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar a {{ $hermano->nombre }}?')" style="background: none; border: none; color: red; cursor: pointer; padding: 0;">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- Muestra los enlaces de paginación --}}
        {{ $hermanos->links() }}
        
    @endif
@endsection