<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | ProcesIA 360 Admin</title>
    <style>
        /* Estilos básicos para el layout */
        body { font-family: 'Arial', sans-serif; display: flex; margin: 0; background-color: #f4f4f4; }
        .sidebar { width: 250px; background-color: #800000; color: white; padding: 20px; height: 100vh; position: fixed; }
        .sidebar h2 { color: #ffcc00; margin-top: 0; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px 0; border-bottom: 1px solid #a03333; }
        .sidebar a:hover { background-color: #a03333; }
        .content { margin-left: 250px; padding: 20px; width: calc(100% - 250px); }
        .header-top { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 2px solid #ddd; margin-bottom: 20px; }
        .btn-primary { background-color: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>ProcesIA 360</h2>
        <p style="color: #ccc;">Administración</p>
        <hr style="border-color: #a03333;">

        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('censo.index') }}">Censo de Hermanos</a>
        <a href="#">Módulo de Cuotas</a>
        <a href="#">Módulo de Inventario</a>

        <div style="margin-top: 50px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ffcc00; cursor: pointer; padding: 0;">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="header-top">
            <h1>@yield('title')</h1> 
            <p>Bienvenido, {{ Auth::user()->email }}</p>
        </div>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>