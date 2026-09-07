<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión - Sistema de Créditos</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }

        .titulo {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .subtitulo {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        .campo input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        .campo input:focus {
            outline: none;
            border-color: #007bff;
        }

        .boton {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton:hover {
            background: #0056b3;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .exito {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="login-box">

        <h1 class="titulo">Sistema de Créditos</h1>

        <p class="subtitulo">
            Inicia sesión para continuar
        </p>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="exito">
                {{ session('success') }}
            </div>
        @endif

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="error">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">

            @csrf

            <div class="campo">
                <label for="email">Correo electrónico</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="correo@ejemplo.com"
                    required
                    autofocus
                >
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Ingresa tu contraseña"
                    required
                >
            </div>

            <button type="submit" class="boton">
                Iniciar sesión
            </button>

        </form>

    </div>

</div>

</body>
</html>