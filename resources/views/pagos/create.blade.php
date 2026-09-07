<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar Pago</title>

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
        select,
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

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info {
            background: #cff4fc;
            color: #055160;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Registrar Pago</h1>


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


    <div class="info">

        Selecciona el crédito al que deseas registrar el pago.

    </div>


    <form
        action="{{ route('pagos.store') }}"
        method="POST"
    >

        @csrf


        <div class="campo">

            <label for="credito_id">
                Crédito
            </label>

            <select
                name="credito_id"
                id="credito_id"
                required
            >

                <option value="">
                    Selecciona un crédito
                </option>


                @foreach($creditos as $credito)

                    <option
                        value="{{ $credito->id }}"
                        {{ old('credito_id') == $credito->id ? 'selected' : '' }}
                    >

                        Crédito #{{ $credito->id }}
                        -
                        {{ $credito->cliente->nombres }}
                        {{ $credito->cliente->apellidos }}
                        -
                        Saldo: ${{ number_format($credito->saldo, 2) }}

                    </option>

                @endforeach

            </select>

        </div>


        <div class="campo">

            <label for="fecha_pago">
                Fecha de pago
            </label>

            <input
                type="date"
                name="fecha_pago"
                id="fecha_pago"
                value="{{ old('fecha_pago', date('Y-m-d')) }}"
                required
            >

        </div>


        <div class="campo">

            <label for="monto">
                Monto del pago
            </label>

            <input
                type="number"
                name="monto"
                id="monto"
                step="0.01"
                min="0.01"
                value="{{ old('monto') }}"
                placeholder="Ejemplo: 300.00"
                required
            >

        </div>


        <div class="campo">

            <label for="referencia">
                Referencia
            </label>

            <input
                type="text"
                name="referencia"
                id="referencia"
                value="{{ old('referencia') }}"
                placeholder="Ejemplo: REC-001"
            >

        </div>


        <div class="campo">

            <label for="observaciones">
                Observaciones
            </label>

            <textarea
                name="observaciones"
                id="observaciones"
                placeholder="Observaciones del pago..."
            >{{ old('observaciones') }}</textarea>

        </div>


        <button
            type="submit"
            class="boton guardar"
        >
            Registrar pago
        </button>


        <a
            href="{{ route('pagos.index') }}"
            class="boton cancelar"
        >
            Cancelar
        </a>

    </form>

</div>

</body>

</html>