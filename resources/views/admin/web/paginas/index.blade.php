@extends('layouts.admin')

@section('title', 'Gestión de Páginas')

@section('content')
<div class="section-one-col">
    <div class="content-card">
        {{-- Cabecera y Buscador --}}
        <div class="table-header-controls controles-tabla-dinamica">
            <form action="{{ route('admin.web.paginas.index') }}" method="GET" class="flex">
                <input type="text" name="search" value="{{ $search }}" 
                        placeholder="Buscar por título o tipo..." class="form-input" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                <div class="btn btn-secondary" style="border-radius:0 var(--radius-md) var(--radius-md) 0">
                    Buscar&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </form>
            <a href="{{ route('admin.web.paginas.create') }}" class="btn btn-primary">
                + Nuevo Contenido
            </a>
        </div>

        {{-- Tabla --}}
        <div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            <a class="sortable-header" href="{{ route('admin.web.paginas.index', ['sort' => 'titulo', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Título
                                @if($sort == 'titulo')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $direction == 'asc' ? 'm18 15-6-6-6 6' : 'm6 9 6 6 6-6' }}"/></svg>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a class="sortable-header" href="{{ route('admin.web.paginas.index', ['sort' => 'tipo', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Tipo
                                @if($sort == 'tipo')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $direction == 'asc' ? 'm18 15-6-6-6 6' : 'm6 9 6 6 6-6' }}"/></svg>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a class="sortable-header" href="{{ route('admin.web.paginas.index', ['sort' => 'publicado', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Estado
                                @if($sort == 'publicado')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $direction == 'asc' ? 'm18 15-6-6-6 6' : 'm6 9 6 6 6-6' }}"/></svg>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a class="sortable-header" href="{{ route('admin.web.paginas.index', ['sort' => 'created_at', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Fecha
                                @if($sort == 'created_at')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $direction == 'asc' ? 'm18 15-6-6-6 6' : 'm6 9 6 6 6-6' }}"/></svg>
                                @endif
                            </a>
                        </th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                @if($post->imagen_destacada)
                                    <div style="background-image:url('{{ asset('storage/' . $post->imagen_destacada) }}');width:40px;height:40px;background-position:center;background-size:cover;" class="">
                                @endif
                            </td>
                            <td><b>{{ $post->titulo }}</b></td>
                            <td>
                                <span>
                                    {{ ucfirst($post->tipo) }}
                                </span>
                            </td>
                            <td>
                                @if($post->publicado)
                                    <span>Publicada</span>
                                @else
                                    <span>Borrador</span>
                                @endif
                            </td>
                            <td>
                                {{ $post->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="flex action-buttons-posts">
                                    <a href="{{ route('admin.web.paginas.edit', $post->id) }}" class="btn btn-secondary"">Editar</a>
                                    <form class="btn btn-danger" action="{{ route('admin.web.paginas.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este contenido?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding: unset;border: unset;background-color: unset;color:white;">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                No se encontraron resultados para "{{ $search }}".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div>
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection