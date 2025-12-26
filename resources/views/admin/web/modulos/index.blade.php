@extends('layouts.admin')

@section('title', 'Diseño y Módulos')

@section('content')
<div class="section-one-col">
    <div class="content-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Funcionalidad</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modulos as $key => $info)
                @php $estaActivo = isset($settings->modulos_config[$key]) && $settings->modulos_config[$key]; @endphp
                <tr>
                    <td>
                        <strong>{{ $info['nombre'] }}</strong>
                    </td>
                    <td>
                        {{ $info['funcionalidad'] }}
                    </td>
                    <td>
                        @if($estaActivo)
                            <span style="color: green; font-weight: bold;">● ACTIVO</span>
                        @else
                            <span style="color: #999;">○ DESACTIVADO</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 10px; align-items: center;">
                            
                            {{-- Botón rápido Activar/Desactivar --}}
                            <form action="{{ route('admin.web.modulos.toggle', $key) }}" method="POST" style="margin: 0;">
                                @csrf
                                @if($estaActivo)
                                    <button type="submit" class="btn btn-back">Desactivar</button>
                                @else
                                    <button type="submit" class="btn btn-secondary">Activar</button>
                                @endif
                            </form>

                            {{-- Botón para Configurar --}}
                            
                                <a class="btn btn-primary" href="{{ route($info['route']) }}">Configurar</a>
                            
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection