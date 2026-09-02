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

        .cancelar {
            margin-left: 10px;
            text-decoration: none;
            color: #555;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Nuevo Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">

        @csrf

        <div class="campo">
            <label>Nombres</label>
            <input type="text" name="nombres" required>
        </div>

        <div class="campo">
            <label>Apellidos</label>
            <input type="text" name="apellidos" required>
        </div>

        <div class="campo">
            <label>Documento de identidad</label>
            <input type="text" name="documento_identidad" required>
        </div>

        <div class="campo">
            <label>Teléfono</label>
            <input type="text" name="telefono" required>
        </div>

        <div class="campo">
            <label>Correo</label>
            <input type="email" name="correo">
        </div>

        <div class="campo">
            <label>Dirección</label>
            <textarea name="direccion"></textarea>
        </div>

        <div class="botones">
            <button type="submit">Guardar cliente</button>

            <a href="{{ route('clientes.index') }}" class="cancelar">
                Cancelar
            </a>
        </div>

    </form>

</div>

</body>
</html>