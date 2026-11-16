<x-guest-layout>
<h4 class="text-center mb-3 fw-bold">Recuperar Contraseña</h4>
    <p class="text-muted small text-center mb-4">
        Ingresa tu correo electrónico y te enviaremos un enlace para que puedas crear una nueva contraseña.
    </p>

    @if (session('status'))
        <div class="alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label fw-bold small">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="ejemplo@tepeaca.edu.mx">
            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-institucional mb-3">
            ENVIAR ENLACE DE RECUPERACIÓN
        </button>
        
        <div class="text-center mt-2">
            <a href="{{ route('login') }}" class="small fw-bold"><i class="fas fa-arrow-left me-1"></i> Volver al Login</a>
        </div>
    </form>
</x-guest-layout>
