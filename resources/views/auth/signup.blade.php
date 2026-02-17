<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link rel="stylesheet" href="{{ asset('bootstrap.min4b.css') }}">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow border-0">

                <div class="card-header bg-white text-center">
                    <h4 class="mb-0">Crear cuenta</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('signup.register') }}">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <input 
                                type="text" 
                                name="nombre" 
                                class="form-control rounded-pill"
                                placeholder="Nombre completo"
                                value="{{ old('nombre') }}" 
                                required>

                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control rounded-pill"
                                placeholder="Correo electrónico"
                                value="{{ old('email') }}" 
                                required>

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control rounded-pill"
                                placeholder="Contraseña"
                                required>

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Confirmar -->
                        <div class="mb-3">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                class="form-control rounded-pill"
                                placeholder="Confirmar contraseña"
                                required>
                        </div>

                        <!-- Botón -->
                        <button type="submit" class="btn btn-warning w-100 font-weight-bold">
                            Registrar
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-white text-center">
                    <small>
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}">Inicia sesión</a>
                    </small>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="{{ asset('jquery.slim.min4b.js') }}"></script>
<script src="{{ asset('bootstrap.bundle.min4b.js') }}"></script>

</body>
</html>
