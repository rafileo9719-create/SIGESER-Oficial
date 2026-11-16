<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a SIGESER - ITST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #621132 0%, #8a1b4a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Source Sans 3', sans-serif;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            max-width: 600px;
        }
        .btn-institucional {
            background-color: white;
            color: #621132;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-institucional:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <h1 class="display-4 fw-bold mb-3">SIGESER</h1>
        <p class="lead mb-4">Sistema de Gestión del Servicio Social y Residencia Profesional</p>
        <p class="mb-5 text-white-50">Instituto Tecnológico Superior de Tepeaca</p>
        <a href="{{ route('login') }}" class="btn-institucional">
            Ingresar al Sistema <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</body>
</html>