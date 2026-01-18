<section id="calendario" class="content-section">
    <div class="section-heading">
        <h1>Próximos eventos:<br><em>Cultos y Actos</em></h1>
    </div>
    <div class="section-content">
        <div class="tabs-content">
            <div class="wrapper">
                
                {{-- NAVEGACIÓN DE TABS --}}
                <ul class="tabs clearfix" data-tabgroup="first-tab-group">
                    @foreach($data['eventos'] as $mesAnio => $eventos)
                        @php 
                            $primerEvento = $eventos->first();
                            $idTab = \Carbon\Carbon::parse($primerEvento->fecha)->format('m_Y');
                        @endphp
                        <li>
                            <a href="#tab_{{ $idTab }}" class="{{ $loop->first ? 'active' : '' }}">
                                {{ Str::ucfirst($mesAnio) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- CONTENIDO DE TABS --}}
                <section id="first-tab-group" class="tabgroup">
                    @foreach($data['eventos'] as $mesAnio => $eventos)
                        @php 
                            $idTab = \Carbon\Carbon::parse($eventos->first()->fecha)->format('m_Y');
                        @endphp
                        
                        <div id="tab_{{ $idTab }}" style="display: {{ $loop->first ? 'block' : 'none' }};">
                            <ul>
                                @foreach($eventos as $evento)
                                    <li class="calendar-item">
                                        <div class="item">
                                            <div class="text-content">
                                                <h4>{{ $evento->titulo }}</h4>
                                                <span>{{ \Carbon\Carbon::parse($evento->fecha)->translatedFormat('d F Y') }}</span>
                                                <p>{{ $evento->lugar }}<br>{{ \Carbon\Carbon::parse($evento->hora)->format('H:i') }}h</p>
                                                <div class="accent-button button">
                                                    <a href="#contact">Añadir a mi calendario</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </section>

            </div>
        </div>
    </div>
</section>