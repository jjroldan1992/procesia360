<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a ProcesIA 360</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .login-box { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; text-align: center; }
        h1 { color: #800000; margin-bottom: 25px; font-size: 1.8em; }
        .error { color: #c00; margin-bottom: 15px; background-color: #fdd; border: 1px solid #c00; padding: 10px; border-radius: 4px; text-align: left; }
        label { display: block; margin-bottom: 8px; text-align: left; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 95%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #800000; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; width: 100%; }
        button:hover { background-color: #a00000; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔐 ProcesIA 360</h1>
        <h2>Panel de Gestión Cofrade</h2>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf <div>
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div style="margin-bottom: 20px; text-align: left;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="display: inline; font-weight: normal;">Recuérdame</label>
            </div>

            <div>
                <button type="submit">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</body>
</html>