@extends('web.templates.saeta.layout')

@section('content')
    
    {{-- Renderizado dinámico según lo que haya cargado el controlador --}}
    
    @if(isset($data['banners']) && $data['banners']->count() > 0)
        @include('web.templates.campanilleros.parts.banners', ['items' => $data['banners']])
    @endif

    @if(isset($data['fast_access']) && $data['fast_access']->count() > 0)
        @include('web.templates.campanilleros.parts.fast_access', ['items' => $data['fast_access']])
    @endif

    @if(isset($data['tablon']) && $data['tablon']->count() > 0)
        @include('web.templates.campanilleros.parts.tablon', ['avisos' => $data['tablon']])
    @endif

    {{-- Repetir para el resto de módulos (calendario, grid, etc.) --}}

@endsection