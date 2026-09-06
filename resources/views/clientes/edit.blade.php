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

        .cancelar {
            background: #6c757d;
            color: white;
            margin-left: 5px;
        }

        .desactivar {
            background: #dc3545;
            color: white;
            margin-left: 5px;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Editar Cliente</h1>

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="campo">

            <label>Nombres</label>

            <input
                type="text"
                name="nombres"
                value="{{ $cliente->nombres }}"
                required
            >

        </div>

        <div class="campo">

            <label>Apellidos</label>

            <input
                type="text"
                name="apellidos"
                value="{{ $cliente->apellidos }}"
                required
            >

        </div>

        <div class="campo">

            <label>Documento de identidad</label>

            <input
                type="text"
                name="documento_identidad"
                value="{{ $cliente->documento_identidad }}"
                required
            >

        </div>

        <div class="campo">

            <label>Teléfono</label>

            <input
                type="text"
                name="telefono"
                value="{{ $cliente->telefono }}"
                required
            >

        </div>

        <div class="campo">

            <label>Correo</label>

            <input
                type="email"
                name="correo"
                value="{{ $cliente->correo }}"
            >

        </div>

        <div class="campo">

            <label>Dirección</label>

            <textarea name="direccion">{{ $cliente->direccion }}</textarea>

        </div>

        <button type="submit" class="boton guardar">
            Actualizar cliente
        </button>

        <a
            href="{{ route('clientes.index') }}"
            class="boton cancelar"
        >
            Cancelar
        </a>

    </form>

    @if($cliente->estado)

        <form
            action="{{ route('clientes.destroy', $cliente) }}"
            method="POST"
            style="display:inline;"
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