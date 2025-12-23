@extends('layouts.admin')

@section('content')
<div class="section-one-col">

    <div class="content-card">

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <a href="{{ route('admin.web.modulos.menu.create') }}" class="btn btn-primary">+ Nuevo Enlace</a>
        </div>

        <div class="dd" id="nestable">
            <ol class="dd-list">
                @foreach($enlaces->where('parent_id', null) as $enlace)
                    @include('admin.web.modulos.menu.partials.item', ['enlace' => $enlace])
                @endforeach
            </ol>
        </div>

    </div>
</div>

{{-- Estilos mínimos para Nestable --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

<script>
    $('#nestable').nestable({
        maxDepth: 2, // Limita a 2 niveles (Padre e Hijo) para no romper el diseño web
        expandBtnHTML: '',        // Eliminamos el botón de expandir
        collapseBtnHTML: '',
        noDragClass: 'dd-nodrag',
        callback: function(l, e) {
            $.ajax({
                url: "{{ route('admin.web.modulos.menu.reorder') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    menu: $('#nestable').nestable('serialize')
                },
                success: function(data) {
                    console.log('Jerarquía guardada');
                }
            });
        }
    });
</script>

<style>
    .dd-item { display: block; margin: 5px 0; }
    .dd-handle { 
        padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 4px; cursor: move; 
        display: flex; justify-content: space-between; align-items: center;
    }
    .dd-list { list-style: none; padding: 0; }
    .dd-list .dd-list { padding-left: 30px; margin-top: 5px; }
</style>
@endsection