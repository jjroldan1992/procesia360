<header class="nav-down responsive-nav hidden-lg hidden-md">
    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <!--/.navbar-header-->
    <div id="main-nav" class="collapse navbar-collapse">
        <nav>
            <ul class="nav navbar-nav">
                @foreach($data['menu'] as $item)
            @php $hasChildren = $item->children->count() > 0; @endphp
            
            <li class="nav-item {{ $hasChildren ? 'menu-item-has-children' : '' }}">
                <a href="{{ $hasChildren ? 'javascript:void(0);' : url($item->url) }}" class="nav-link">
                    {{ $item->nombre }}
                    @if($hasChildren)
                        <i class="fa fa-chevron-down submenu-indicator"></i>
                    @endif
                </a>

                @if($hasChildren)
                    <ul class="sub-menu" style="display: none; padding-left: unset; list-style: none;">
                        @foreach($item->children as $hijo)
                            <li>
                                <a href="{{ url($hijo->url) }}" style="font-size: 0.9em; opacity: 0.8;">
                                    {{ $hijo->nombre }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
            </ul>
        </nav>
    </div>
</header>

<div class="sidebar-navigation hidde-sm hidden-xs">
    <div class="logo">
        <a href="{{ route('web.home') }}">
            <img width="100%" src="{{ asset('storage/' . $settings->logo_path) }}">
            <span>{{ config('app.cliente_nombre') }}</span>
        </a>
    </div>
    <nav>
        <ul>
            @foreach($data['menu'] as $item)
            @php $hasChildren = $item->children->count() > 0; @endphp
            
                <li class="nav-item {{ $hasChildren ? 'menu-item-has-children' : '' }}">
                    <a href="{{ $hasChildren ? 'javascript:void(0);' : url($item->url) }}" class="nav-link">
                        {{ $item->nombre }}
                        @if($hasChildren)
                            <i class="fa fa-chevron-down submenu-indicator"></i>
                        @endif
                    </a>

                    @if($hasChildren)
                        <ul class="sub-menu" style="display: none; padding-left: unset; list-style: none;">
                            @foreach($item->children as $hijo)
                                <li class="sub-menu-li">
                                    <a href="{{ url($hijo->url) }}" style="font-size: 0.9em; opacity: 0.8;">
                                        {{ $hijo->nombre }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
    @if (isset($data["redes"]))
    <ul class="social-icons">
        @foreach ($data["redes"] as $item)
        <li><a href="{{ $item->url }}"><i class="fa-brands fa-{{ $item->red }}"></i></a></li>
        @endforeach
    </ul>
    @endif
</div>