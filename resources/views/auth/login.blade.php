<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | ProcesIA 360</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> 
</head>
<body>
    <div class="login-card">
        
        <header class="login-header">
            {{-- Logo del Header Principal --}}
            <img 
                src="{{ asset('img/logo-procesia360-dark.png') }}" 
                alt="Logo ProcesIA 360" 
                class="login-logo js-theme-logo"
            >
            
            <h1 class="login-title">Bienvenido</h1>
            <p class="login-subtitle">{{ config('app.cliente_nombre_corto') }}</p>
        </header>

        {{-- Mensajes de Error (Validación y Credenciales) --}}
        @if ($errors->any())
            <div class="error-message">
                Las credenciales proporcionadas no coinciden con nuestros registros.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf 
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus placeholder="ejemplo@cofradia.es">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" class="form-input" required placeholder="••••••••">
                <div style="text-align: right; margin-top: 5px;">
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>
            </div>

            <div class="remember-me">
                <div style="display: flex; align-items: center;">
                    <input type="checkbox" name="remember" id="remember" style="margin-right: 5px;">
                    <label for="remember">Recuérdame</label>
                </div>
                {{-- Dejamos el enlace de olvido de contraseña en el form-group de arriba --}}
            </div>
            
            <div class="form-group" style="margin-top: 2rem;">
                <button type="submit" class="btn-login">
                    Iniciar Sesión
                </button>
            </div>
        </form>
        
        {{-- Opción de registro (opcional, como en la plantilla de Figma) --}}
        <p style="margin-top: 2rem; font-size: 0.875rem; color: var(--color-text-muted);">
            ¿Necesitas acceso? Contacta al Administrador.
        </p>
    </div>
</body>
</html>