<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Crédito</title>

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

        .dato {
            padding: 12px 0;
            border-bottom: 1px solid #ddd;
        }

        .dato strong {
            display: inline-block;
            width: 220px;
        }

        /* Cuota mensual */
        .cuota {
            background: #e8f4ff;
            border: 2px solid #0d6efd;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            font-size: 18px;
        }

        .cuota strong {
            display: inline-block;
            width: 220px;
        }

        .cuota .valor {
            color: #0d6efd;
            font-weight: bold;
            font-size: 20px;
        }

        .activo {
            color: green;
            font-weight: bold;
        }

        .pagado {
            color: blue;
            font-weight: bold;
        }

        .vencido,
        .cancelado {
            color: red;
            font-weight: bold;
        }

        .boton {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .volver {
            background: #6c757d;
            color: white;
        }

        .editar {
            background: #ffc107;
            color: black;
            margin-left: 5px;
        }

        .pagos {
            background: #0d6efd;
            color: white;
            margin-left: 5px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Detalle del Crédito #{{ $credito->id }}</h1>

    <div class="dato">
        <strong>Cliente:</strong>
        {{ $credito->cliente->nombres }}
        {{ $credito->cliente->apellidos }}
    </div>

    <div class="dato">
        <strong>Documento:</strong>
        {{ $credito->cliente->documento_identidad }}
    </div>

    <div class="dato">
        <strong>Fecha de otorgamiento:</strong>
        {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
    </div>

    <div class="dato">
        <strong>Monto:</strong>
        ${{ number_format($credito->monto, 2) }}
    </div>

    <div class="dato">
        <strong>Tasa de interés:</strong>
        {{ $credito->tasa_interes }}%
    </div>

    <div class="dato">
        <strong>Plazo:</strong>
        {{ $credito->plazo }} meses
    </div>

    {{-- CUOTA MENSUAL --}}
    <div class="cuota">
        <strong>Cuota mensual:</strong>

        <span class="valor">
            ${{ number_format($credito->cuota_mensual, 2) }}
        </span>
    </div>

    <div class="dato">
        <strong>Total del crédito:</strong>
        ${{ number_format($credito->total_credito, 2) }}
    </div>

    <div class="dato">
        <strong>Saldo pendiente:</strong>
        ${{ number_format($credito->saldo, 2) }}
    </div>

    <div class="dato">
        <strong>Fecha de vencimiento:</strong>
        {{ $credito->fecha_vencimiento->format('d/m/Y') }}
    </div>

    <div class="dato">
        <strong>Estado:</strong>

        @if($credito->estado === 'Activo')

            <span class="activo">
                Activo
            </span>

        @elseif($credito->estado === 'Pagado')

            <span class="pagado">
                Pagado
            </span>

        @elseif($credito->estado === 'Vencido')

            <span class="vencido">
                Vencido
            </span>

        @else

            <span class="cancelado">
                {{ $credito->estado }}
            </span>

        @endif

    </div>


    {{-- BOTÓN PARA VER PAGOS --}}
    <a
        href="{{ route('pagos.index') }}"
        class="boton pagos"
    >
        Ver pagos
    </a>


    {{-- VOLVER --}}
    <a
        href="{{ route('creditos.index') }}"
        class="boton volver"
    >
        Volver
    </a>


    {{-- SOLO ADMINISTRADOR PUEDE EDITAR --}}
    @if(Auth::user()->rol === 'Administrador')

        <a
            href="{{ route('creditos.edit', $credito) }}"
            class="boton editar"
        >
            Editar
        </a>

    @endif

</div>

</body>
</html>