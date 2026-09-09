<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Créditos - Sistema de Créditos</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f8;
        }

        .contenedor {
            max-width: 1300px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 25px;
        }

        /* ==============================
           NAVEGACIÓN
        ============================== */

        .navegacion {
            margin-bottom: 25px;
        }

        .btn-dashboard {
            display: inline-block;
            padding: 10px 15px;
            background: #212529;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-dashboard:hover {
            background: #343a40;
        }

        /* ==============================
           BARRA
        ============================== */

        .barra {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filtro {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
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

        .btn-editar {
            background: #ffc107;
            color: black;
        }

        .btn-cancelar {
            background: #dc3545;
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

        .activo {
            color: green;
            font-weight: bold;
        }

        .pagado {
            color: blue;
            font-weight: bold;
        }

        .vencido {
            color: orange;
            font-weight: bold;
        }

        .cancelado {
            color: red;
            font-weight: bold;
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

        /* ==============================
           RESPONSIVE
        ============================== */

        @media (max-width: 768px) {

            body {
                margin: 20px;
            }

            .barra {
                flex-wrap: wrap;
            }

            .filtro {
                width: 100%;
            }

        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Gestión de Créditos</h1>


    {{-- ==============================
         BOTÓN DASHBOARD
    ============================== --}}

    <div class="navegacion">

        <a
            href="{{ route('dashboard') }}"
            class="btn-dashboard"
        >
             Dashboard
        </a>

    </div>


    @if(session('success'))

        <div class="mensaje">

            {{ session('success') }}

        </div>

    @endif


    <div class="barra">

        <form
            action="{{ route('creditos.index') }}"
            method="GET"
        >

            <select
                name="estado"
                class="filtro"
                onchange="this.form.submit()"
            >

                <option value="">
                    Todos los créditos
                </option>

                <option
                    value="Activo"
                    {{ ($estado ?? '') === 'Activo' ? 'selected' : '' }}
                >
                    Activos
                </option>

                <option
                    value="Pagado"
                    {{ ($estado ?? '') === 'Pagado' ? 'selected' : '' }}
                >
                    Pagados
                </option>

                <option
                    value="Vencido"
                    {{ ($estado ?? '') === 'Vencido' ? 'selected' : '' }}
                >
                    Vencidos
                </option>

                <option
                    value="Cancelado"
                    {{ ($estado ?? '') === 'Cancelado' ? 'selected' : '' }}
                >
                    Cancelados
                </option>

            </select>

        </form>


        {{-- Solo Administrador puede crear créditos --}}

        @if(Auth::user()->rol === 'Administrador')

            <a
                href="{{ route('creditos.create') }}"
                class="btn btn-nuevo"
            >
                Nuevo crédito
            </a>

        @endif

    </div>


    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Interés</th>
                <th>Total</th>
                <th>Saldo</th>
                <th>Vencimiento</th>
                <th>Estado</th>
                <th>Acciones</th>

            </tr>

        </thead>


        <tbody>

            @forelse($creditos as $credito)

                <tr>

                    <td>
                        {{ $credito->id }}
                    </td>

                    <td>
                        {{ $credito->cliente->nombres }}
                        {{ $credito->cliente->apellidos }}
                    </td>

                    <td>
                        {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
                    </td>

                    <td>
                        ${{ number_format($credito->monto, 2) }}
                    </td>

                    <td>
                        {{ $credito->tasa_interes }}%
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

                    </td>


                    <td>

                        {{-- Todos pueden consultar --}}

                        <a
                            href="{{ route('creditos.show', $credito) }}"
                            class="btn btn-ver"
                        >
                            Ver
                        </a>


                        {{-- Solo Administrador puede editar o cancelar --}}

                        @if(Auth::user()->rol === 'Administrador')

                            <a
                                href="{{ route('creditos.edit', $credito) }}"
                                class="btn btn-editar"
                            >
                                Editar
                            </a>


                            @if($credito->estado === 'Activo')

                                <form
                                    action="{{ route('creditos.destroy', $credito) }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-cancelar"
                                        onclick="return confirm('¿Deseas cancelar este crédito?')"
                                    >
                                        Cancelar
                                    </button>

                                </form>

                            @endif

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="10"
                        class="sin-resultados"
                    >
                        No hay créditos registrados.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>

</html>