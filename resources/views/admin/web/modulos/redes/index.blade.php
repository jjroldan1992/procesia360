@extends('layouts.admin')

@section('title', 'Redes Sociales')

@section('content')

<div class="section-one-col">
    <div class="content-card">
        <form action="{{ route('admin.web.modulos.redes.update') }}" method="POST">
            @csrf
            @foreach($redesDefinidas as $red)
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #eee;">
                <div style="width: 120px; font-weight: bold; text-transform: capitalize;">
                    {{ $red }}
                </div>
                <div style="flex-grow: 1;">
                    <input type="url" name="redes[{{ $red }}][url]" 
                        class="form-input" 
                        placeholder="https://{{ $red }}.com/tu-hermandad"
                        value="{{ $redesActivas[$red]->url ?? '' }}">
                </div>
            </div>
            @endforeach
            
            <button type="submit" class="btn btn-primary">Guardar Enlaces</button>
        </form>
    </div>
</div>

@endsection