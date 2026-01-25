<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') | ProcesIA 360 Admin</title>
        <meta name="robots" content="noindex, nofollow">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script>
            // Script de ejecución inmediata para evitar el "Flickering"
            (function() {
                const storedTheme = localStorage.getItem('theme');
                
                // Función para aplicar la clase dark
                const applyDark = (shouldBeDark) => {
                    if (shouldBeDark) {
                        document.documentElement.classList.add('dark');
                    }
                };
        
                // 1. Si hay una preferencia guardada: usarla.
                if (storedTheme === 'dark') {
                    applyDark(true);
                    return; // Detenemos la ejecución si ya hemos aplicado el tema.
                }
        
                // 2. Si no hay preferencia guardada, pero el sistema operativo prefiere dark: usarla.
                if (!storedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    applyDark(true);
                    return;
                }
                
                // 3. Si se guarda "light" o por defecto, no se hace nada (se usa el CSS base).
        
            })();
        </script>
        
        {{-- Nota: El resto de tu código que maneja el click del botón toggle
             y la persistencia en localStorage debe permanecer en el script
             principal dentro de document.addEventListener('DOMContentLoaded', ...).
             Este script inline solo se encarga de la aplicación visual inmediata.
        --}}

    </head>
    <body>
        
        <aside class="sidebar" id="menu-mobile">
            
            <nav class="space-y-2">

                <div class="menu-header">

                    {{-- ESCUDO DE LA HERMANDAD --}}
                    <div class="escudo-header-container">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('img/escudo.png') }}" class="escudo-header">
                        </a>
                    </div>
                    
                    <div class="header-title">{{ config('app.cliente_nombre_corto') }}</div>
                    <div class="header-subtitle">{{ config('app.cliente_nombre') }}</div>

                </div>

                <h3 class="menu-title">Administración</h3>

                <a href="{{ route('dashboard') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house" aria-hidden="true"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                    Inicio
                </a>

                <a href="#" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                    Calendario
                </a>

                <a href="{{ route('documentos.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text" aria-hidden="true"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                    Documentos
                </a>

                <h3 class="menu-title">Secretaría</h3>
                
                <a href="{{ route('censo.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    Censo de Hermanos
                </a>

                <h3 class="menu-title">Tesorería</h3>
                
                <a href="{{ route('tesoreria.dashboard') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-euro-icon lucide-euro"><path d="M4 10h12"/><path d="M4 14h9"/><path d="M19 6a7.7 7.7 0 0 0-5.2-2A7.9 7.9 0 0 0 6 12c0 4.4 3.5 8 7.8 8 2 0 3.8-.8 5.2-2"/></svg>
                    Resumen financiero
                </a>

                <a href="{{ route('movimientos.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-table-properties-icon lucide-table-properties"><path d="M15 3v18"/><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M21 9H3"/><path d="M21 15H3"/></svg>
                    Movimientos
                </a>

                <a href="#" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                    Cuotas
                </a>
                
                <h3 class="menu-title">Mayordomía</h3>
                
                <a href="#" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-box" aria-hidden="true"><path d="M21 8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"></path><path d="M12 2v4"></path><path d="M12 18v4"></path><path d="M18 10h-2"></path><path d="M8 10H6"></path></svg>
                    Inventario
                </a>

                <h3 class="menu-title">Zona Web</h3>

                <a href="{{ route('admin.web.paginas.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notepad-text-icon lucide-notepad-text"><path d="M8 2v4"/><path d="M12 2v4"/><path d="M16 2v4"/><rect width="16" height="18" x="4" y="4" rx="2"/><path d="M8 10h6"/><path d="M8 14h8"/><path d="M8 18h5"/></svg>
                    Páginas
                </a>
                
                <a href="#" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-lock-icon lucide-user-lock"><circle cx="10" cy="7" r="4"/><path d="M10.3 15H7a4 4 0 0 0-4 4v2"/><path d="M15 15.5V14a2 2 0 0 1 4 0v1.5"/><rect width="8" height="5" x="13" y="16" rx=".899"/></svg>
                    Acceso Hermanos
                </a>

                <a href="{{ route('admin.web.modulos.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-paintbrush-icon lucide-paintbrush"><path d="m14.622 17.897-10.68-2.913"/><path d="M18.376 2.622a1 1 0 1 1 3.002 3.002L17.36 9.643a.5.5 0 0 0 0 .707l.944.944a2.41 2.41 0 0 1 0 3.408l-.944.944a.5.5 0 0 1-.707 0L8.354 7.348a.5.5 0 0 1 0-.707l.944-.944a2.41 2.41 0 0 1 3.408 0l.944.944a.5.5 0 0 0 .707 0z"/><path d="M9 8c-1.804 2.71-3.97 3.46-6.583 3.948a.507.507 0 0 0-.302.819l7.32 8.883a1 1 0 0 0 1.185.204C12.735 20.405 16 16.792 16 15"/></svg>
                    Módulos
                </a>

                <a href="{{ route('admin.web.config.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor-cog-icon lucide-monitor-cog"><path d="M12 17v4"/><path d="m14.305 7.53.923-.382"/><path d="m15.228 4.852-.923-.383"/><path d="m16.852 3.228-.383-.924"/><path d="m16.852 8.772-.383.923"/><path d="m19.148 3.228.383-.924"/><path d="m19.53 9.696-.382-.924"/><path d="m20.772 4.852.924-.383"/><path d="m20.772 7.148.924.383"/><path d="M22 13v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><path d="M8 21h8"/><circle cx="18" cy="6" r="3"/></svg>
                    Configuración Web
                </a>

                <h3 class="menu-title">Configurar</h3>
                
                <a href="{{ route('config.index') }}" class="sidebar-link sidebar-link-inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cog-icon lucide-cog"><path d="M11 10.27 7 3.34"/><path d="m11 13.73-4 6.93"/><path d="M12 22v-2"/><path d="M12 2v2"/><path d="M14 12h8"/><path d="m17 20.66-1-1.73"/><path d="m17 3.34-1 1.73"/><path d="M2 12h2"/><path d="m20.66 17-1.73-1"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m3.34 7 1.73 1"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="12" r="8"/></svg>
                    Ajustes de tu {{ config('app.cliente_tipo') }}
                </a>
            </nav>

        </aside>

        <div class="content">

            <header class="main-header">
                <div class="header-content">
                    <div class="branding">
    
                        {{-- BOTÓN HAMBURGUESA (Visible solo en móvil) --}}
                        <button id="mobile-menu-toggle" class="mobile-toggle-btn" aria-label="Menú principal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
                        </button>
                        
                        <div>
                            <h1 class="app-title">@yield('title')</h1>
                            <p class="app-subtitle">Gestión Integral de Hermandades y Cofradías</p>
                        </div>
                    </div>
    
                    <div class="user-actions">
                        <button id="theme-toggle" class="notifications-button" title="Alternar tema oscuro/claro">
                            {{-- Icono SVG de un sol/luna --}}
                            <svg id="theme-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun h-5 w-5 text-gray-600" aria-hidden="true">
                                <circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path>
                            </svg>
                        </button>
                        
                        {{-- Botón de Notificaciones (replicado del SVG bell) --}}
                        <button class="notifications-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell" aria-hidden="true"><path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"></path></svg>
                            <span class="notification-badge"></span>
                        </button>
                        
                        {{-- Perfil del Usuario Autenticado --}}
                        <div id="user-menu-trigger" class="user-profile">
                            @php
                                $avatarUrl = Auth::user()->avatar_url; // Usa el Accesor simple
                            @endphp
                            
                            @if ($avatarUrl)
                                {{-- 1. Si hay avatar, mostramos la imagen --}}
                                <img 
                                    id="current-avatar-preview"
                                    src="{{ $avatarUrl }}"
                                    alt="Avatar de Usuario"
                                    class="avatar-display avatar-small"
                                >
                            @else
                                {{-- 2. Si no hay avatar, mostramos el fallback de iniciales --}}
                                <span 
                                    id="current-avatar-preview"
                                    class="avatar-display avatar-initials-fallback"
                                >
                                    {{ Auth::user()->initials }}
                                </span>
                            @endif
                            <div class="text-left">
                                <p class="user-name">{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</p>
                                {{-- Usamos la relación para obtener el nombre del rol --}}
                                <p class="user-role">{{ Auth::user()->rol->nombre ?? 'Sin rol asignado' }}</p>
                            </div>
                        </div>
    
                        {{-- 2. EL MENÚ DESPLEGABLE (Oculto por defecto) --}}
                        <div id="user-menu-dropdown" class="user-dropdown-menu">
                            
                            {{-- Opción 1: Editar Perfil (Sin funcionalidad por ahora) --}}
                            <a href="#" class="dropdown-item">
                                <i class="lucide lucide-user-edit mr-2"></i> Editar mi Perfil
                            </a>
                            
                            {{-- Separador Visual --}}
                            <div class="dropdown-divider"></div>
    
                            {{-- Opción 2: Cerrar Sesión (FUNCIONALIDAD REQUERIDA) --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="lucide lucide-log-out mr-2"></i> Cerrar Sesión
                                </button>
                            </form>
    
                        </div>
                    </div>
                </div>
            </header>

            <main>
                @yield('content')
                <div class="content-footer content-card">
                    <p><b>{{ config('app.cliente_nombre') }}</b></p>
                    <p><img src="{{ asset('img/logo-procesia360-dark.png') }}" alt="Logo ProcesIA 360" class="main-logo-footer js-theme-logo"><br>&copy; 2025 - {{ date('Y') }} | <b>ProcesIA 360</b> - Desarrollado por <b>J. Jesús Roldán</b></p>
                </div>
            </main>
        </div>


        <div id="offcanvas-profile-edit" class="offcanvas-overlay">
            <div class="offcanvas-panel content-card">
                
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title">
                        Editar mi Perfil
                        <button type="button" class="close-offcanvas-btn" data-target="offcanvas-profile-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </h3>
                </div>

                <div class="offcanvas-body">
                    
                    <form id="profile-edit-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        {{-- Campo Foto de Perfil (Subida y Previsualización) --}}
                        <div class="form-group text-center mb-4">
                            
                            {{-- Contenedor de la Foto de Perfil (Subida y Previsualización) --}}
                            <div class="form-group text-center mb-4">
                                
                                <div class="avatar-display-container">
                                    @php
                                        $avatarUrl = Auth::user()->avatar_url; // Usa el Accesor simple
                                    @endphp
                                    
                                    @if ($avatarUrl)
                                        {{-- 1. Si hay avatar, mostramos la imagen --}}
                                        <img 
                                            id="current-avatar-preview"
                                            src="{{ $avatarUrl }}"
                                            alt="Avatar de Usuario"
                                            class="avatar-display avatar-large"
                                        >
                                    @endif
                                    
                                    <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
                                    
                                    <button type="button" class="btn btn-secondary btn-sm mt-3" 
                                            onclick="document.getElementById('avatar-input').click()">
                                        Subir Foto
                                    </button>
                                </div>
                                @error('avatar')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="profile_name">Nombre</label>
                            <input type="text" id="profile_name" name="nombre" class="form-input" value="{{ old('nombre', Auth::user()->nombre) }}" required>
                            @error('nombre') <small class="text-danger mt-1">{{ $message }}</small> @enderror 
                        </div>

                        <div class="form-group">
                            <label for="profile_apellidos">Apellidos</label>
                            <input type="text" id="profile_apellidos" name="apellidos" class="form-input" value="{{ old('apellidos', Auth::user()->apellidos) }}" required>
                            @error('apellidos') <small class="text-danger mt-1">{{ $message }}</small> @enderror 
                        </div>

                        <div class="form-group">
                            <label for="profile_email">Email</label>
                            <input type="email" id="profile_email" name="email" class="form-input" value="{{ Auth::user()->email }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="profile_password">Nueva Contraseña (Opcional)</label>
                            <input type="password" id="profile_password" name="password" class="form-input" placeholder="Dejar vacío para no cambiar">
                        </div>

                        <div class="form-group">
                            <label for="profile_password_confirmation">Confirmar Contraseña</label>
                            <input type="password" id="profile_password_confirmation" name="password_confirmation" class="form-input" placeholder="Repite la nueva contraseña">
                        </div>
                           
                        <div class="form-actions" style="padding-bottom:2rem">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toggleButton = document.getElementById('theme-toggle');
                const htmlElement = document.documentElement; // La etiqueta <html>
                const appLogos = document.querySelectorAll('.js-theme-logo');

                // ICONOS DE PRUEBA (puedes reemplazarlos por SVGs más bonitos)
                const sunIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun h-5 w-5 text-gray-600" aria-hidden="true"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>`;
                const moonIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon h-5 w-5 text-gray-600" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>`;

                /**
                 * Aplica la clase .dark y actualiza el icono.
                 */
                function setTheme(isDark) {
                    if (isDark) {
                        htmlElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        toggleButton.innerHTML = moonIcon; // Mostrar la luna (estamos en oscuro)
                    } else {
                        htmlElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        toggleButton.innerHTML = sunIcon; // Mostrar el sol (estamos en claro)
                    }
                    const themeSuffix = isDark ? '-light.png' : '-dark.png';
                    const baseName = 'logo-procesia360'; // Nombre base del archivo
                    
                    // Iteramos sobre todos los elementos con la clase js-theme-logo
                    appLogos.forEach(logo => {
                        const assetPath = `/img/${baseName}${themeSuffix}`; 
                        logo.src = assetPath;
                    });
                }

                //1. Cargar la preferencia al inicio (si existe)
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches; // Preferencia del sistema operativo

                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    setTheme(true);
                } else {
                    setTheme(false);
                }

                // 2. Manejar el click del botón
                toggleButton.addEventListener('click', () => {
                    const isDark = htmlElement.classList.contains('dark');
                    setTheme(!isDark);
                });

                // --- Lógica de Enlace Activo ---
                const sidebarLinks = document.querySelectorAll('.sidebar-link');
                const currentPath = window.location.href; 
                
                // Función para limpiar todos los estados activos
                function clearActiveClass() {
                    sidebarLinks.forEach(link => {
                        // Quitamos la clase de activo
                        link.classList.remove('sidebar-link-active');
                        // Restauramos la clase de inactivo (necesaria para el hover/color por defecto)
                        link.classList.add('sidebar-link-inactive'); 
                    });
                }

                // Aplicar el estado activo basado en la URL
                clearActiveClass();
                
                sidebarLinks.forEach(link => {
                    // Comparamos la URL de la página con el href del enlace
                    if (currentPath.includes(link.href) && link.href.length > 0) {
                        // Si encontramos una coincidencia (la ruta actual contiene la ruta del enlace)
                        link.classList.remove('sidebar-link-inactive');
                        link.classList.add('sidebar-link-active');
                    }
                });

                // Opcional: Si quieres que al hacer clic se guarde el estado inmediatamente (aunque la recarga lo hace)
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        // Limpiar y aplicar la clase activa al enlace clicado
                        clearActiveClass();
                        link.classList.remove('sidebar-link-inactive');
                        link.classList.add('sidebar-link-active');
                    });
                });

                // --- Lógica del Menú Desplegable de Usuario ---
                const trigger = document.getElementById('user-menu-trigger');
                const menu = document.getElementById('user-menu-dropdown');
                
                // El nuevo enlace para abrir el Offcanvas
                const editProfileLink = menu.querySelector('.dropdown-item'); 
                
                // El Offcanvas
                const offcanvasProfile = document.getElementById('offcanvas-profile-edit');
                const closeOffcanvasBtn = offcanvasProfile.querySelector('.close-offcanvas-btn');
                

                // Lógica de Toggle del Menú Desplegable (existente)
                if (trigger && menu) {
                    trigger.addEventListener('click', () => {
                        menu.classList.toggle('active');
                    });

                    // Cerrar el menú si se hace clic fuera
                    document.addEventListener('click', (e) => {
                        if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.remove('active');
                        }
                    });
                }
                
                // -----------------------------------------------------------------
                // NUEVA LÓGICA: Abrir Offcanvas desde el Menú Desplegable
                // -----------------------------------------------------------------
                if (editProfileLink && offcanvasProfile) {
                    editProfileLink.addEventListener('click', (e) => {
                        e.preventDefault(); // Evita que el enlace # se recargue
                        
                        menu.classList.remove('active'); // 1. Cierra el menú desplegable
                        offcanvasProfile.classList.add('active'); // 2. Abre el Offcanvas
                        document.body.style.overflow = 'hidden'; // Bloquea el scroll del body
                    });
                }
                
                // Lógica para Cerrar el Offcanvas
                if (closeOffcanvasBtn && offcanvasProfile) {
                    closeOffcanvasBtn.addEventListener('click', () => {
                        offcanvasProfile.classList.remove('active');
                        document.body.style.overflow = ''; // Restaura el scroll
                    });
                    
                    // Cerrar al hacer click en el overlay
                    offcanvasProfile.addEventListener('click', function(e) {
                        if (e.target === offcanvasProfile) {
                            offcanvasProfile.classList.remove('active');
                            document.body.style.overflow = '';
                        }
                    });
                }

                const menu_mobile = document.getElementById('menu-mobile');

                // Lógica propia menú mobile
                document.getElementById('mobile-menu-toggle').addEventListener('click', () => {
                    menu_mobile.classList.toggle('menu-mobile-visible');
                });

                document.addEventListener('click', function (event) {
                    // event.clientX indica la posición del clic en el eje X
                    if (event.clientX > 325 && menu_mobile.classList.contains('menu-mobile-visible')) {
                        menu_mobile.classList.toggle('menu-mobile-visible');
                    };
                });

                const avatarInput = document.getElementById('avatar-input');
                const avatarPreview = document.getElementById('current-avatar-preview');

                if (avatarInput && avatarPreview) {
                    avatarInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                avatarPreview.src = e.target.result; // Muestra la imagen seleccionada
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }
            
            });

            document.addEventListener('click', (event) => {
                // 1. Intentamos encontrar la fila clicable más cercana al elemento clickeado.
                const row = event.target.closest('.js-clickable-row');
                
                // Si no se hizo clic en una fila clicable, o si la fila no tiene URL, salimos.
                if (!row || !row.hasAttribute('data-href')) {
                    return;
                }

                // 2. Verificar si el clic se originó dentro de la celda de acciones (para ignorarlo)
                const actionCell = event.target.closest('.action-cell-no-click');
                
                // 3. Verificar si el clic fue en un botón o enlace interactivo dentro de la fila
                const interactiveElement = event.target.closest('a, button');

                // Si el clic NO fue en la celda de acciones y NO fue en un botón/enlace interactivo:
                if (!actionCell && !interactiveElement) {
                    const url = row.getAttribute('data-href');
                    window.location.href = url;
                }
            });

            // --- Lógica del Dropdown de la Sidebar (MODIFICADA) ---
            document.querySelectorAll('.sidebar-dropdown-group').forEach(group => {
                const toggleButton = group.querySelector('.sidebar-dropdown-toggle');
                const content = group.querySelector('.sidebar-dropdown-content');

                if (toggleButton && content) {
                    // Asegurar que el estado inicial de max-height sea correcto
                    if (group.classList.contains('open')) {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        // Si carga abierto por coincidencia de ruta, se mantiene activo
                        toggleButton.classList.add('sidebar-link-active'); 
                    }

                    toggleButton.addEventListener('click', () => {
                        const isClosing = group.classList.contains('open');
                        
                        // 1. Toggle la clase 'open' en el grupo
                        group.classList.toggle('open');
                        
                        // 2. Controlar la clase de estilo ACTIVO en el botón (NUEVA LÓGICA)
                        if (isClosing) {
                            // Si estaba abierto y se va a cerrar: Quitar estilo activo
                            content.style.maxHeight = '0';
                            toggleButton.classList.remove('sidebar-link-active');
                        } else {
                            // Si estaba cerrado y se va a abrir: Poner estilo activo (VERDE)
                            content.style.maxHeight = content.scrollHeight + 'px';
                            toggleButton.classList.add('sidebar-link-active');
                        }
                    });
                }
            });
        </script>
        
    </body>
</html>