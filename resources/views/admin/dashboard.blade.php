<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ProcesIA 360</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background-color: #f7f7f7; }
        .header { background-color: #800000; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .role-badge { background-color: #ffcc00; color: #333; padding: 5px 10px; border-radius: 4px; font-weight: bold; display: inline-block; }
        .info-box { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .logout-form { margin-top: 20px; }
        .logout-form button { background-color: #c00; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenido al Panel de Gestión (Junta Directiva)</h1>
    </div>

    <div class="info-box">
        <h2>Detalles del Usuario</h2>
        <p><strong>Correo:</strong> {{ $usuario->email }}</p>
        <p><strong>Rol Asignado:</strong> 
            {{-- Usamos la relación 'rol' del modelo Usuario para obtener el nombre --}}
            <span class="role-badge">{{ $usuario->rol->nombre ?? 'N/A' }} (ID: {{ $usuario->rol_id }})</span>
        </p>
        
        <p>¡Felicidades! Tienes acceso a los módulos de Censo, Cuotas y Tesorería.</p>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>

</body>
</html>