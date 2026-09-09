<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cliente</title>

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
            font-weight: bold;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        .boton {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .guardar {
            background: #198754;
            color: white;
        }

        .guardar:hover {
            background: #157347;
        }

        .cancelar {
            background: #6c757d;
            color: white;
            margin-left: 5px;
        }

        .cancelar:hover {
            background: #5c636a;
        }

        .desactivar {
            background: #dc3545;
            color: white;
            margin-left: 5px;
        }

        .desactivar:hover {
            background: #bb2d3b;
        }

        .errores {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .errores ul {
            margin: 8px 0 0 20px;
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

    <h1>Editar Cliente</h1>

    @if($errors->any())

        <div class="errores">

            <strong>Corrige los siguientes errores:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('clientes.update', $cliente) }}"
        method="POST"
    >

        @csrf

        @method('PUT')

        <!-- NOMBRES -->

        <div class="campo">

            <label>Nombres</label>

            <input
                type="text"
                name="nombres"
                value="{{ old('nombres', $cliente->nombres) }}"
                required
            >

        </div>

        <!-- APELLIDOS -->

        <div class="campo">

            <label>Apellidos</label>

            <input
                type="text"
                name="apellidos"
                value="{{ old('apellidos', $cliente->apellidos) }}"
                required
            >

        </div>

        <!-- DOCUMENTO -->

        <div class="campo">

            <label>Documento de identidad</label>

            <input
                type="text"
                name="documento_identidad"
                value="{{ old('documento_identidad', $cliente->documento_identidad) }}"
                required
            >

        </div>

        <!-- TELÉFONO -->

        <div class="campo">

            <label>Teléfono</label>

            <input
                type="text"
                name="telefono"
                value="{{ old('telefono', $cliente->telefono) }}"
                required
            >

        </div>

        <!-- CORREO -->

        <div class="campo">

            <label>Correo electrónico</label>

            <input
                type="email"
                name="correo"
                value="{{ old('correo', $cliente->correo) }}"
                required
            >

            <div class="ayuda">
                Este correo también será utilizado para iniciar sesión.
            </div>

        </div>

        <!-- DIRECCIÓN -->

        <div class="campo">

            <label>Dirección</label>

            <textarea name="direccion">{{ old('direccion', $cliente->direccion) }}</textarea>

        </div>

        <!-- BOTONES -->

        <button
            type="submit"
            class="boton guardar"
        >
            Actualizar cliente
        </button>

        <a
            href="{{ route('clientes.index') }}"
            class="boton cancelar"
        >
            Cancelar
        </a>

    </form>

    <!-- DESACTIVAR CLIENTE -->

    @if($cliente->estado)

        <form
            action="{{ route('clientes.destroy', $cliente) }}"
            method="POST"
            style="display: inline;"
        >

            @csrf

            @method('DELETE')

            <button
                type="submit"
                class="boton desactivar"
                onclick="return confirm('¿Deseas desactivar este cliente?')"
            >
                Desactivar cliente
            </button>

        </form>

    @endif

</div>

</body>

</html>