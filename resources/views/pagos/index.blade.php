<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pagos - Sistema de Créditos</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f8;
        }

        .contenedor {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 25px;
        }

        .barra {
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-nuevo {
            background: #198754;
            color: white;
        }

        .btn-ver {
            background: #0d6efd;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #212529;
            color: white;
        }

        .mensaje {
            padding: 12px;
            background: #d1e7dd;
            color: #0f5132;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .sin-resultados {
            text-align: center;
            padding: 20px;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Gestión de Pagos</h1>

    @if(session('success'))

        <div class="mensaje">
            {{ session('success') }}
        </div>

    @endif


    <div class="barra">

        <a
            href="{{ route('pagos.create') }}"
            class="btn btn-nuevo"
        >
            Nuevo pago
        </a>

    </div>


    <table>

        <thead>

            <tr>

                <th>ID</th>

                <th>Cliente</th>

                <th>Crédito</th>

                <th>Fecha</th>

                <th>Monto</th>

                <th>Referencia</th>

                <th>Acciones</th>

            </tr>

        </thead>


        <tbody>

            @forelse($pagos as $pago)

                <tr>

                    <td>
                        {{ $pago->id }}
                    </td>


                    <td>

                        {{ $pago->credito->cliente->nombres }}
                        {{ $pago->credito->cliente->apellidos }}

                    </td>


                    <td>

                        #{{ $pago->credito_id }}

                    </td>


                    <td>

                        {{ $pago->fecha_pago->format('d/m/Y') }}

                    </td>


                    <td>

                        ${{ number_format($pago->monto, 2) }}

                    </td>


                    <td>

                        {{ $pago->referencia ?? 'Sin referencia' }}

                    </td>


                    <td>

                        <a
                            href="{{ route('pagos.show', $pago) }}"
                            class="btn btn-ver"
                        >
                            Ver
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="sin-resultados"
                    >
                        No hay pagos registrados.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>

</html>