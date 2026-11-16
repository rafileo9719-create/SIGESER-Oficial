<x-guest-layout>
<h4 class="text-center mb-4 fw-bold">Iniciar Sesión</h4>

    @if (session('status'))
        <div class="alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-bold small">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="ejemplo@tepeaca.edu.mx">
            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold small">Contraseña</label>
            <input id="password" type="password" name="password" required class="form-control" placeholder="********">
            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Recordarme</label>
            </div>
            <a href="{{ route('password.request') }}" class="small fw-bold">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn-institucional mb-3">
            ENTRAR AL SISTEMA
        </button>
    </form>
</x-guest-layout>
