<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nuevo Cliente</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .contenedor {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        .botones {
            margin-top: 20px;
        }

        button {
            background: #198754;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #157347;
        }

        .cancelar {
            margin-left: 10px;
            text-decoration: none;
            color: #555;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .ayuda {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Nuevo Cliente</h1>

    @if($errors->any())

        <div class="error">

            <strong>Corrige los siguientes errores:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('clientes.store') }}" method="POST">

        @csrf

        <!-- NOMBRES -->

        <div class="campo">

            <label>Nombres</label>

            <input
                type="text"
                name="nombres"
                value="{{ old('nombres') }}"
                required
            >

        </div>

        <!-- APELLIDOS -->

        <div class="campo">

            <label>Apellidos</label>

            <input
                type="text"
                name="apellidos"
                value="{{ old('apellidos') }}"
                required
            >

        </div>

        <!-- DOCUMENTO -->

        <div class="campo">

            <label>Documento de identidad</label>

            <input
                type="text"
                name="documento_identidad"
                value="{{ old('documento_identidad') }}"
                required
            >

        </div>

        <!-- TELÉFONO -->

        <div class="campo">

            <label>Teléfono</label>

            <input
                type="text"
                name="telefono"
                value="{{ old('telefono') }}"
                required
            >

        </div>

        <!-- CORREO -->

        <div class="campo">

            <label>Correo electrónico</label>

            <input
                type="email"
                name="correo"
                value="{{ old('correo') }}"
                required
            >

            <div class="ayuda">
                Este correo será utilizado para iniciar sesión.
            </div>

        </div>

        <!-- CONTRASEÑA -->

        <div class="campo">

            <label>Contraseña</label>

            <input
                type="password"
                name="password"
                required
                minlength="8"
            >

            <div class="ayuda">
                La contraseña debe tener al menos 8 caracteres.
            </div>

        </div>

        <!-- CONFIRMAR CONTRASEÑA -->

        <div class="campo">

            <label>Confirmar contraseña</label>

            <input
                type="password"
                name="password_confirmation"
                required
                minlength="8"
            >

        </div>

        <!-- DIRECCIÓN -->

        <div class="campo">

            <label>Dirección</label>

            <textarea name="direccion">{{ old('direccion') }}</textarea>

        </div>

        <!-- BOTONES -->

        <div class="botones">

            <button type="submit">
                Guardar cliente
            </button>

            <a
                href="{{ route('clientes.index') }}"
                class="cancelar"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

</body>

</html>