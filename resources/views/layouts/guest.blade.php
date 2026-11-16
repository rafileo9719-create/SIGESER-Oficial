<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'SIGESER') }}</title>
        
        <!-- Fonts y Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body { background-color: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; }
            .auth-card { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 450px; padding: 3rem 2.5rem; border-top: 6px solid #621132; }
            .auth-logo { text-align: center; margin-bottom: 2rem; }
            .auth-logo i { font-size: 3.5rem; color: #621132; }
            .form-control { border-radius: 8px; padding: 12px; }
            .form-control:focus { border-color: #621132; box-shadow: 0 0 0 0.25rem rgba(98, 17, 50, 0.25); }
            .btn-institucional { background-color: #621132; color: white; border-radius: 8px; padding: 12px; font-weight: bold; width: 100%; transition: 0.3s; border: none; }
            .btn-institucional:hover { background-color: #4a0e27; color: white; }
            a { color: #621132; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>
        <!-- Scripts de Vite/Breeze (necesario para que funcione el Login) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
