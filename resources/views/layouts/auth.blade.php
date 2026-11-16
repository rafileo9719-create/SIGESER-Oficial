<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGESER - Autenticación</title>
    <!-- Bootstrap 5 y FontAwesome (Los que usa AdminLTE) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9; /* Gris claro institucional */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans 3', sans-serif;
        }
        .auth-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 3rem 2.5rem;
            border-top: 6px solid #621132; /* Línea vino superior */
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo i {
            font-size: 3.5rem;
            color: #621132;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #621132;
            box-shadow: 0 0 0 0.25rem rgba(98, 17, 50, 0.25);
        }
        .btn-institucional {
            background-color: #621132;
            color: white;
            border-radius: 8px;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
        }
        .btn-institucional:hover {
            background-color: #4a0e27;
            color: white;
        }
        a { color: #621132; text-decoration: none; }
        a:hover { text-decoration: underline; color: #4a0e27; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <i class="fas fa-graduation-cap"></i>
            <h2 class="mt-2 fw-bold" style="color: #621132;">SIGESER</h2>
            <p class="text-muted small">Servicio Social y Residencia Profesional</p>
        </div>
        
        {{ $slot }}
        
    </div>
</body>
</html>