<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pagos - Sistema de Créditos</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #212529;
        }


        /* ========================================
           ESTRUCTURA
        ======================================== */

        .layout {
            min-height: 100vh;
            display: flex;
        }


        /* ========================================
           MENU LATERAL
        ======================================== */

        .sidebar {
            width: 250px;
            background: #1f2937;
            color: white;
            padding: 25px 18px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .logo {
            padding: 5px 12px 30px;
            border-bottom: 1px solid #374151;
            margin-bottom: 25px;
        }

        .logo h1 {
            font-size: 21px;
            font-weight: 600;
        }

        .logo p {
            margin-top: 6px;
            font-size: 12px;
            color: #9ca3af;
        }


        /* ========================================
           MENU
        ======================================== */

        .menu-titulo {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 12px 10px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu a {
            text-decoration: none;
            color: #d1d5db;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a:hover {
            background: #374151;
            color: white;
        }

        .menu a.activo {
            background: #2563eb;
            color: white;
        }


        /* ========================================
           CONTENIDO
        ======================================== */

        .contenido {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }


        /* ========================================
           BARRA SUPERIOR
        ======================================== */

        .topbar {
            min-height: 72px;
            background: white;
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 15px 35px;
        }

        .topbar-titulo h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .topbar-titulo p {
            margin-top: 4px;
            font-size: 13px;
            color: #6b7280;
        }

        .usuario {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .usuario-info {
            text-align: right;
        }

        .usuario-nombre {
            display: block;
            font-size: 14px;
            font-weight: 600;
        }

        .rol {
            display: inline-block;
            margin-top: 3px;
            font-size: 11px;
            color: #2563eb;
            font-weight: bold;
        }

        .logout {
            background: #dc3545;
            color: white;
            border: none;
            padding: 9px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        .logout:hover {
            background: #bb2d3b;
        }


        /* ========================================
           PRINCIPAL
        ======================================== */

        .principal {
            padding: 35px;
        }


        /* ========================================
           ENCABEZADO
        ======================================== */

        .encabezado {
            margin-bottom: 25px;
        }

        .encabezado h1 {
            font-size: 25px;
            font-weight: 600;
        }

        .encabezado p {
            color: #6b7280;
            font-size: 13px;
            margin-top: 5px;
        }


        /* ========================================
           MENSAJE
        ======================================== */

        .mensaje {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            padding: 13px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 14px;
        }


        /* ========================================
           BARRA DE ACCIONES
        ======================================== */

        .herramientas {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;

            display: flex;
            justify-content: flex-end;
            align-items: center;
        }


        /* ========================================
           BOTONES
        ======================================== */

        .btn {
            display: inline-block;

            padding: 9px 13px;

            border: none;

            border-radius: 6px;

            text-decoration: none;

            cursor: pointer;

            font-size: 12px;

            font-weight: 600;

            margin-right: 4px;
        }

        .btn:last-child {
            margin-right: 0;
        }

        .btn-nuevo {
            background: #198754;
            color: white;
        }

        .btn-nuevo:hover {
            background: #157347;
        }

        .btn-ver {
            background: #2563eb;
            color: white;
        }

        .btn-ver:hover {
            background: #1d4ed8;
        }

        .btn-editar {
            background: #ffc107;
            color: #212529;
        }

        .btn-editar:hover {
            background: #e0a800;
        }

        .btn-eliminar {
            background: #dc3545;
            color: white;
        }

        .btn-eliminar:hover {
            background: #bb2d3b;
        }


        /* ========================================
           TABLA
        ======================================== */

        .tabla-contenedor {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 950px;
        }

        th {
            background: #1f2937;

            color: white;

            padding: 14px 15px;

            text-align: left;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 0.3px;

            white-space: nowrap;
        }

        td {
            padding: 14px 15px;

            border-bottom: 1px solid #e5e7eb;

            font-size: 13px;

            color: #374151;

            white-space: nowrap;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }


        /* ========================================
           MONTO
        ======================================== */

        .monto {
            font-weight: bold;
            color: #111827;
        }


        /* ========================================
           ACCIONES
        ======================================== */

        .acciones {
            white-space: nowrap;
        }

        .acciones form {
            display: inline;
        }


        /* ========================================
           SIN RESULTADOS
        ======================================== */

        .sin-resultados {
            text-align: center;

            padding: 40px;

            color: #6b7280;
        }


        /* ========================================
           RESPONSIVE
        ======================================== */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .contenido {
                margin-left: 210px;

                width: calc(100% - 210px);
            }

            .principal {
                padding: 25px;
            }

        }


        @media (max-width: 700px) {

            .layout {
                display: block;
            }

            .sidebar {
                position: relative;

                width: 100%;

                padding: 20px;
            }

            .contenido {
                margin-left: 0;

                width: 100%;
            }

            .menu {
                flex-direction: row;

                flex-wrap: wrap;
            }

            .topbar {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;

                padding: 20px;
            }

            .usuario {
                width: 100%;

                justify-content: space-between;
            }

            .usuario-info {
                text-align: left;
            }

            .principal {
                padding: 20px;
            }

            .herramientas {
                justify-content: stretch;
            }

            .btn-nuevo {
                width: 100%;
                text-align: center;
            }

        }

    </style>

</head>


<body>

<div class="layout">


    <!-- ========================================
         MENU LATERAL
    ======================================== -->

    <aside class="sidebar">

        <div class="logo">

            <h1>Sistema de Créditos</h1>

            <p>Gestión y administración</p>

        </div>


        <div class="menu-titulo">
            Menú principal
        </div>


        <nav class="menu">

            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>


            <a href="{{ route('clientes.index') }}">

                @if(Auth::user()->rol === 'Administrador')
                    Clientes
                @else
                    Mi información
                @endif

            </a>


            <a href="{{ route('creditos.index') }}">

                @if(Auth::user()->rol === 'Administrador')
                    Créditos
                @else
                    Mis créditos
                @endif

            </a>


            <a
                href="{{ route('pagos.index') }}"
                class="activo"
            >

                @if(Auth::user()->rol === 'Administrador')
                    Pagos
                @else
                    Mis pagos
                @endif

            </a>

        </nav>

    </aside>


    <!-- ========================================
         CONTENIDO
    ======================================== -->

    <div class="contenido">


        <!-- ====================================
             BARRA SUPERIOR
        ==================================== -->

        <header class="topbar">

            <div class="topbar-titulo">

                <h2>

                    @if(Auth::user()->rol === 'Administrador')
                        Pagos
                    @else
                        Mis pagos
                    @endif

                </h2>


                <p>

                    @if(Auth::user()->rol === 'Administrador')
                        Gestión de pagos del sistema
                    @else
                        Consulta de tus pagos registrados
                    @endif

                </p>

            </div>


            <div class="usuario">

                <div class="usuario-info">

                    <span class="usuario-nombre">
                        {{ Auth::user()->name }}
                    </span>

                    <span class="rol">
                        {{ Auth::user()->rol }}
                    </span>

                </div>


                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout"
                    >
                        Cerrar sesión
                    </button>

                </form>

            </div>

        </header>


        <!-- ====================================
             PRINCIPAL
        ==================================== -->

        <main class="principal">


            <!-- ENCABEZADO -->

            <div class="encabezado">

                <h1>

                    @if(Auth::user()->rol === 'Administrador')
                        Gestión de Pagos
                    @else
                        Mis pagos
                    @endif

                </h1>


                <p>

                    @if(Auth::user()->rol === 'Administrador')
                        Consulta y registra los pagos realizados en el sistema.
                    @else
                        Consulta los pagos realizados sobre tus créditos.
                    @endif

                </p>

            </div>


            <!-- ====================================
                 MENSAJE
            ==================================== -->

            @if(session('success'))

                <div class="mensaje">

                    {{ session('success') }}

                </div>

            @endif


            <!-- ====================================
                 NUEVO PAGO
            ==================================== -->

            <div class="herramientas">

                <a
                    href="{{ route('pagos.create') }}"
                    class="btn btn-nuevo"
                >
                    Nuevo pago
                </a>

            </div>


            <!-- ====================================
                 TABLA
            ==================================== -->

            <div class="tabla-contenedor">

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


                                <!-- ID -->

                                <td>
                                    {{ $pago->id }}
                                </td>


                                <!-- CLIENTE -->

                                <td>

                                    <strong>

                                        {{ $pago->credito->cliente->nombres }}

                                        {{ $pago->credito->cliente->apellidos }}

                                    </strong>

                                </td>


                                <!-- CREDITO -->

                                <td>
                                    #{{ $pago->credito_id }}
                                </td>


                                <!-- FECHA -->

                                <td>
                                    {{ $pago->fecha_pago->format('d/m/Y') }}
                                </td>


                                <!-- MONTO -->

                                <td>

                                    <span class="monto">

                                        ${{ number_format($pago->monto, 2) }}

                                    </span>

                                </td>


                                <!-- REFERENCIA -->

                                <td>

                                    {{ $pago->referencia ?? 'Sin referencia' }}

                                </td>


                                <!-- ACCIONES -->

                                <td class="acciones">

                                    <a
                                        href="{{ route('pagos.show', $pago) }}"
                                        class="btn btn-ver"
                                    >
                                        Ver
                                    </a>


                                    @if(Auth::user()->rol === 'Administrador')

                                        <a
                                            href="{{ route('pagos.edit', $pago) }}"
                                            class="btn btn-editar"
                                        >
                                            Editar
                                        </a>


                                        <form
                                            action="{{ route('pagos.destroy', $pago) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Está seguro de eliminar este pago? Esta acción restaurará el saldo del crédito.');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-eliminar"
                                            >
                                                Eliminar
                                            </button>

                                        </form>

                                    @endif

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


        </main>

    </div>

</div>

</body>

</html>