@extends('web.templates.mektub.layout')

@section('content')

    @if(isset($data['menu']))
        @include('web.templates.mektub.parts.menu', ['items' => $data['menu']])
    @endif

    @if(isset($data['banners']))
        @include('web.templates.mektub.parts.banners', ['items' => $data['banners']])
    @endif

    <div class="page-content">

        @if(isset($data['fast_access']))
            @include('web.templates.mektub.parts.fast_access', ['items' => $data['fast_access']])
        @endif


        @if(isset($data['eventos']))
            @include('web.templates.mektub.parts.calendario', ['items' => $data['eventos']])
        @endif

        @if(isset($data['grid_items']))
            @include('web.templates.mektub.parts.grid', ['items' => $data['grid_items']])
        @endif
        
        @if(isset($data['tablon']))
            @include('web.templates.mektub.parts.tablon', ['items' => $data['tablon']])
        @endif

        @if(isset($data['contacto']))
            @include('web.templates.mektub.parts.contacto', ['items' => $data["contacto"]])
        @endif

        @if(isset($data['footer_links']))
            @include('web.templates.mektub.parts.links', ['items' => $data["footer_links"]])
        @endif

    </div>
    
@endsection