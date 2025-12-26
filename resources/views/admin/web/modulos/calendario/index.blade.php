@extends('layouts.admin')
@section('title', 'Calendario de eventos')
@section('content')
<div class="section-one-col">
    <div class="section-two-cols">
        
        {{-- Listado de Eventos --}}
        <div class="content-card">
            <h3>Próximos Eventos</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Evento</th>
                        <th>Tipo</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventos as $ev)
                    <tr>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($ev->fecha)->format('d/m/Y') }}</strong><br>
                            <small>{{ $ev->hora ? substr($ev->hora, 0, 5) : 'Sin hora' }}</small>
                        </td>
                        <td>
                            <strong>{{ $ev->titulo }}</strong><br>
                            <small>{{ $ev->lugar }}</small>
                        </td>
                        <td>
                            <span style="font-size: 11px; padding: 2px 6px; background: #e2e8f0; border-radius: 4px;">
                                {{ $tipos[$ev->tipo] ?? $ev->tipo }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 5px;">
                                <a href="{{ route('admin.web.modulos.calendario.edit', $ev->id) }}" class="btn btn-secondary" style="padding: 5px;">Editar</a>
                                <form action="{{ route('admin.web.modulos.calendario.destroy', $ev->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-back" style="padding: 5px;">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Formulario de Creación --}}
        <div class="content-card">
            <h3>Nuevo Evento</h3>
            <form action="{{ route('admin.web.modulos.calendario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Título del Evento</label>
                    <input type="text" name="titulo" class="form-input" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hora (Opcional)</label>
                        <input type="time" name="hora" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo de Evento</label>
                    <select name="tipo" class="form-input" required>
                        @foreach($tipos as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Lugar</label>
                    <input type="text" name="lugar" class="form-input" placeholder="Ej: Parroquia de San Bartolomé">
                </div>

                <div class="form-group">
                    <label class="form-label">Cartel / Imagen (Opcional)</label>
                    <input type="file" name="cartel" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Observaciones Adicionales</label>
                    <textarea name="observaciones" class="form-input" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Añadir al Calendario</button>
            </form>
        </div>
    </div>
</div>
@endsection