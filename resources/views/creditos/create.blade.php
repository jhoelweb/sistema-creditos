<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nuevo Crédito</title>

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
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .error {
            color: #dc3545;
            margin-top: 5px;
            font-size: 14px;
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

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Registrar Nuevo Crédito</h1>

    <form action="{{ route('creditos.store') }}" method="POST">

        @csrf

        <div class="campo">

            <label for="cliente_id">
                Cliente
            </label>

            <select name="cliente_id" id="cliente_id" required>

                <option value="">
                    Selecciona un cliente
                </option>

                @foreach($clientes as $cliente)

                    <option
                        value="{{ $cliente->id }}"
                        {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}
                    >
                        {{ $cliente->nombres }}
                        {{ $cliente->apellidos }}
                        - {{ $cliente->documento_identidad }}
                    </option>

                @endforeach

            </select>

            @error('cliente_id')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>


        <div class="campo">

            <label for="fecha_otorgamiento">
                Fecha de otorgamiento
            </label>

            <input
                type="date"
                name="fecha_otorgamiento"
                id="fecha_otorgamiento"
                value="{{ old('fecha_otorgamiento', date('Y-m-d')) }}"
                required
            >

            @error('fecha_otorgamiento')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>


        <div class="campo">

            <label for="monto">
                Monto del crédito
            </label>

            <input
                type="number"
                name="monto"
                id="monto"
                step="0.01"
                min="0.01"
                value="{{ old('monto') }}"
                placeholder="Ejemplo: 1000.00"
                required
            >

            @error('monto')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>


        <div class="campo">

            <label for="tasa_interes">
                Tasa de interés (%)
            </label>

            <input
                type="number"
                name="tasa_interes"
                id="tasa_interes"
                step="0.01"
                min="0"
                value="{{ old('tasa_interes') }}"
                placeholder="Ejemplo: 10"
                required
            >

            @error('tasa_interes')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>


        <div class="campo">

            <label for="plazo">
                Plazo (meses)
            </label>

            <input
                type="number"
                name="plazo"
                id="plazo"
                min="1"
                value="{{ old('plazo') }}"
                placeholder="Ejemplo: 12"
                required
            >

            @error('plazo')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>


        <button
            type="submit"
            class="boton guardar"
        >
            Registrar crédito
        </button>


        <a
            href="{{ route('creditos.index') }}"
            class="boton cancelar"
        >
            Cancelar
        </a>

    </form>

</div>

</body>

</html>