<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del Pago</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f8;
        }

        .contenedor {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 30px;
        }

        .dato {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .dato strong {
            width: 250px;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 25px;
            border-radius: 5px;
            text-decoration: none;
        }

        .volver {
            background: #6c757d;
            color: white;
        }

        .credito {
            background: #0d6efd;
            color: white;
            margin-left: 5px;
        }

        .recibo {
            background: #198754;
            color: white;
            margin-left: 5px;
        }

        .recibo:hover {
            background: #157347;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Detalle del Pago #{{ $pago->id }}</h1>


    <div class="dato">

        <strong>Cliente:</strong>

        <span>

            {{ $pago->credito->cliente->nombres }}

            {{ $pago->credito->cliente->apellidos }}

        </span>

    </div>


    <div class="dato">

        <strong>Crédito:</strong>

        <span>

            #{{ $pago->credito->id }}

        </span>

    </div>


    <div class="dato">

        <strong>Fecha de pago:</strong>

        <span>

            {{ $pago->fecha_pago->format('d/m/Y') }}

        </span>

    </div>


    <div class="dato">

        <strong>Monto pagado:</strong>

        <span>

            ${{ number_format($pago->monto, 2) }}

        </span>

    </div>


    <div class="dato">

        <strong>Referencia:</strong>

        <span>

            {{ $pago->referencia ?? 'Sin referencia' }}

        </span>

    </div>


    <div class="dato">

        <strong>Observaciones:</strong>

        <span>

            {{ $pago->observaciones ?? 'Sin observaciones' }}

        </span>

    </div>


    <!-- ========================================
         BOTONES
    ======================================== -->

    <a
        href="{{ route('pagos.index') }}"
        class="boton volver"
    >
        Volver
    </a>


    <a
        href="{{ route('creditos.show', $pago->credito) }}"
        class="boton credito"
    >
        Ver crédito
    </a>


    <a
        href="{{ route('pagos.recibo', $pago) }}"
        class="boton recibo"
    >
         Imprimir recibo
    </a>


</div>

</body>

</html>