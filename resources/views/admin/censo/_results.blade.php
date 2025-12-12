@if($hermanos->isEmpty())
    <p class="text-muted-center" style="padding: 20px;">No se encontraron hermanos que coincidan con la búsqueda.</p>
@else
    <table class="data-table">
        <thead>
            <tr>
                {{-- Función auxiliar para generar URL de ordenamiento --}}
                @php
                    // Obtener parámetros actuales de la URL (si ya existe search, sort, direction)
                    $currentSort = request('sort');
                    $currentDirection = request('direction', 'asc');
                    
                    // Función para alternar dirección y generar la URL
                    $getSortUrl = function($column) use ($currentSort, $currentDirection) {
                        $direction = ($currentSort == $column && $currentDirection == 'asc') ? 'desc' : 'asc';
                        return route('censo.index', array_merge(request()->query(), ['sort' => $column, 'direction' => $direction]));
                    };
                    
                    // Función para mostrar el icono de ordenamiento
                    $getSortIcon = function($column) use ($currentSort, $currentDirection) {
                        if ($currentSort != $column) return '';
                        return $currentDirection == 'asc' ? ' &uarr;' : ' &darr;'; // Flechas Unicode
                    };
                @endphp

                <th>
                    <a href="{{ $getSortUrl('numero_hermano') }}" class="sortable-header">Nº Hermano {!! $getSortIcon('numero_hermano') !!}</a>
                </th>
                <th>
                    <a href="{{ $getSortUrl('nombre') }}" class="sortable-header">Hermano {!! $getSortIcon('nombre') !!}</a>
                </th>
                <th>DNI</th>
                <th>
                    <a href="{{ $getSortUrl('fecha_alta') }}" class="sortable-header">Fecha de Alta {!! $getSortIcon('fecha_alta') !!}</a>
                </th>
                <th>Antigüedad</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody id="censo-table-body">
            @foreach($hermanos as $hermano)

                <tr class="js-clickable-row" data-href="{{ route('censo.show', $hermano) }}">

                    <td data-label="Nº Hermano">
                        <strong class="text-default">{{ $hermano->numero_hermano ?? '-' }}</strong>
                    </td>

                    <td data-label="Hermano">
                        <strong class="text-default">{{ $hermano->nombre }} {{ $hermano->apellido }}</strong><br>
                        <span class="text-muted">{{$hermano->domicilio_calle}}, {{$hermano->domicilio_numero}} {{$hermano->domicilio_cp}} {{$hermano->domicilio_poblacion}} ({{$hermano->domicilio_provincia}})</span>
                    </td>
                    
                    <td data-label="DNI">{{ $hermano->dni }}</td>
                    
                    <td data-label="Alta">
                        {{ $hermano->fecha_alta->translatedFormat('j \d\e F \d\e Y') }}
                    </td>
                    
                    <td data-label="Antigüedad">
                        {{ $hermano->fecha_alta->diff(\Carbon\Carbon::now())->format('%y años, %m meses y %d días') }}
                    </td>

                    <td data-label="Estado">
                        @if ($hermano->fecha_baja)
                            <span class="text-danger" style="font-weight: bold;">BAJA</span>
                        @else
                            <span class="text-success" style="font-weight: bold;">ACTIVO</span>
                        @endif
                    </td>
                    
                    <td data-label="Acciones" class="action-buttons-cell action-cell-no-click">
                        <a href="{{ route('censo.show', $hermano) }}" class="icon-btn" title="Ver Ficha">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s5-7 10-7 10 7 10 7-5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="{{ route('censo.edit', $hermano) }}" class="icon-btn" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.85 0 0 0-4 0L7 13.06l-.55 3.91 3.91-.55L21 7.06a2.85 2.85 0 0 0 0-4Z"></path><path d="m15 5 4 4"></path></svg>
                        </a>
                        
                        <form action="{{ route('censo.destroy', $hermano) }}" method="POST" class="inline-delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar a {{ $hermano->nombre }}?')" class="icon-btn delete-btn" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination-footer">
        {{ $hermanos->links() }}
    </div>
@endif