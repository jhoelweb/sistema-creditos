<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ver Cliente</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .contenedor {
            max-width: 1000px;
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

        /* ==============================
           HISTORIAL DE CRÉDITOS
        ============================== */

        .historial {
            margin-top: 40px;
        }

        .historial h2 {
            margin-bottom: 20px;
        }

        .tabla-contenedor {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #0d6efd;
            color: white;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .estado {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .activo {
            background: #d1e7dd;
            color: #0f5132;
        }

        .pagado {
            background: #cff4fc;
            color: #055160;
        }

        .vencido {
            background: #f8d7da;
            color: #842029;
        }

        .cancelado {
            background: #e2e3e5;
            color: #41464b;
        }

        .ver-credito {
            background: #0d6efd;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .sin-creditos {
            padding: 20px;
            text-align: center;
            background: #f1f1f1;
            border-radius: 8px;
            color: #666;
        }

        @media (max-width: 700px) {

            body {
                padding: 20px;
            }

            .contenedor {
                padding: 20px;
            }

        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Información del Cliente</h1>

    <div class="campo">

        <strong>ID</strong>

        <div class="dato">
            {{ $cliente->id }}
        </div>

    </div>


    <div class="campo">

        <strong>Nombres</strong>

        <div class="dato">
            {{ $cliente->nombres }}
        </div>

    </div>


    <div class="campo">

        <strong>Apellidos</strong>

        <div class="dato">
            {{ $cliente->apellidos }}
        </div>

    </div>


    <div class="campo">

        <strong>Documento de identidad</strong>

        <div class="dato">
            {{ $cliente->documento_identidad }}
        </div>

    </div>


    <div class="campo">

        <strong>Teléfono</strong>

        <div class="dato">
            {{ $cliente->telefono }}
        </div>

    </div>


    <div class="campo">

        <strong>Correo</strong>

        <div class="dato">
            {{ $cliente->correo ?? 'No registrado' }}
        </div>

    </div>


    <div class="campo">

        <strong>Dirección</strong>

        <div class="dato">
            {{ $cliente->direccion ?? 'No registrada' }}
        </div>

    </div>


    <div class="campo">

        <strong>Estado</strong>

        <div class="dato">
            {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
        </div>

    </div>


    <!-- =========================================
         HISTORIAL DE CRÉDITOS
    ========================================== -->

    <div class="historial">

        <h2>Historial de Créditos</h2>

        @if($cliente->creditos->count() > 0)

            <div class="tabla-contenedor">

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Fecha</th>

                            <th>Monto</th>

                            <th>Total</th>

                            <th>Saldo</th>

                            <th>Vencimiento</th>

                            <th>Estado</th>

                            <th>Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($cliente->creditos as $credito)

                            <tr>

                                <td>
                                    #{{ $credito->id }}
                                </td>

                                <td>
                                    {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
                                </td>

                                <td>
                                    ${{ number_format($credito->monto, 2) }}
                                </td>

                                <td>
                                    ${{ number_format($credito->total_credito, 2) }}
                                </td>

                                <td>
                                    ${{ number_format($credito->saldo, 2) }}
                                </td>

                                <td>
                                    {{ $credito->fecha_vencimiento->format('d/m/Y') }}
                                </td>

                                <td>

                                    @if($credito->estado === 'Activo')

                                        <span class="estado activo">
                                            Activo
                                        </span>

                                    @elseif($credito->estado === 'Pagado')

                                        <span class="estado pagado">
                                            Pagado
                                        </span>

                                    @elseif($credito->estado === 'Vencido')

                                        <span class="estado vencido">
                                            Vencido
                                        </span>

                                    @else

                                        <span class="estado cancelado">
                                            Cancelado
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{ route('creditos.show', $credito) }}"
                                        class="ver-credito"
                                    >
                                        Ver
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="sin-creditos">

                Este cliente todavía no tiene créditos registrados.

            </div>

        @endif

    </div>


    <!-- BOTONES -->

    <a
        href="{{ route('clientes.index') }}"
        class="boton volver"
    >
        Volver
    </a>


    @if(Auth::user()->rol === 'Administrador')

        <a
            href="{{ route('clientes.edit', $cliente) }}"
            class="boton editar"
        >
            Editar
        </a>

    @endif

</div>

</body>

</html>