<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Cliente</title>

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
            margin-bottom: 18px;
        }

        .campo strong {
            display: block;
            margin-bottom: 5px;
        }

        .dato {
            padding: 10px;
            background: #f1f1f1;
            border-radius: 5px;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            margin-right: 5px;
        }

        .volver {
            background: #6c757d;
            color: white;
        }

        .editar {
            background: #ffc107;
            color: black;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Información del Cliente</h1>

    <div class="campo">
        <strong>ID</strong>
        <div class="dato">{{ $cliente->id }}</div>
    </div>

    <div class="campo">
        <strong>Nombres</strong>
        <div class="dato">{{ $cliente->nombres }}</div>
    </div>

    <div class="campo">
        <strong>Apellidos</strong>
        <div class="dato">{{ $cliente->apellidos }}</div>
    </div>

    <div class="campo">
        <strong>Documento de identidad</strong>
        <div class="dato">{{ $cliente->documento_identidad }}</div>
    </div>

    <div class="campo">
        <strong>Teléfono</strong>
        <div class="dato">{{ $cliente->telefono }}</div>
    </div>

    <div class="campo">
        <strong>Correo</strong>
        <div class="dato">{{ $cliente->correo }}</div>
    </div>

    <div class="campo">
        <strong>Dirección</strong>
        <div class="dato">{{ $cliente->direccion }}</div>
    </div>

    <div class="campo">
        <strong>Estado</strong>
        <div class="dato">
            {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
        </div>
    </div>

    <a href="{{ route('clientes.index') }}" class="boton volver">
        Volver
    </a>

    <a href="{{ route('clientes.edit', $cliente) }}" class="boton editar">
        Editar
    </a>

</div>

</body>
</html>