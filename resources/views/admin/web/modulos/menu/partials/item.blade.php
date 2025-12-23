<li class="dd-item" data-id="{{ $enlace->id }}">
    <div class="dd-handle" style="padding:2rem 1rem">
        <div style="display: flex; align-items: center;">
            {{-- Icono de arrastre --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 12px; color: #9ca3af;"><circle cx="9" cy="12" r="1"/><circle cx="9" cy="5" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="19" r="1"/></svg>
            <div>
                <span>{{ $enlace->nombre }}</span>
                @if ($enlace->url != "#")
                    <br><span style="font-size:var(--text-xs);color:var(--color-text-muted);">{{ $enlace->url }}</span>
                @endif
            </div>
        </div>

        <div style="display: flex; gap: 12px; align-items: center;">
            <span class="badge-status {{ $enlace->activo ? 'status-active' : 'status-hidden' }}">
                @if ($enlace->activo)
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" style="green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" style="gray" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
                @endif
            </span>
            
            <a href="{{ route('admin.web.modulos.menu.edit', $enlace->id) }}" class="btn btn-secondary dd-nodrag" style="padding: 4px 10px; font-size: 12px;">Editar</a>
            
            <form action="{{ route('admin.web.modulos.menu.destroy', $enlace->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar enlace?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-back dd-nodrag" style="padding: 4px 10px; font-size: 12px;">X</button>
            </form>
        </div>
    </div>
    
    @if($enlace->children->count() > 0)
        <ol class="dd-list">
            @foreach($enlace->children as $child)
                @include('admin.web.modulos.menu.partials.item', ['enlace' => $child])
            @endforeach
        </ol>
    @endif
</li>