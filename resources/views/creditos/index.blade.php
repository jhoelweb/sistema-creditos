<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Créditos - Sistema de Créditos</title>

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
           HERRAMIENTAS
        ======================================== */

        .herramientas {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            padding: 20px;

            margin-bottom: 20px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }

        .filtro-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filtro-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .filtro {
            padding: 10px 13px;

            border-radius: 6px;

            border: 1px solid #d1d5db;

            font-size: 14px;

            background: white;

            min-width: 190px;

            outline: none;
        }

        .filtro:focus {
            border-color: #2563eb;
        }


        /* ========================================
           BOTONES
        ======================================== */

        .btn {
            display: inline-block;

            padding: 10px 15px;

            border: none;

            border-radius: 6px;

            text-decoration: none;

            cursor: pointer;

            font-size: 13px;

            font-weight: 600;
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
            background: #f59e0b;
            color: white;
        }

        .btn-editar:hover {
            background: #d97706;
        }

        .btn-cancelar {
            background: #dc3545;
            color: white;
        }

        .btn-cancelar:hover {
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

            min-width: 1100px;
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
           ESTADOS
        ======================================== */

        .estado {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }

        .activo {
            background: #d1e7dd;
            color: #0f5132;
        }

        .pagado {
            background: #dbeafe;
            color: #1e40af;
        }

        .vencido {
            background: #fef3c7;
            color: #92400e;
        }

        .cancelado {
            background: #f8d7da;
            color: #842029;
        }


        /* ========================================
           SALDO
        ======================================== */

        .saldo {
            font-weight: bold;
        }


        /* ========================================
           ACCIONES
        ======================================== */

        .acciones {
            display: flex;

            align-items: center;

            gap: 6px;

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

            .herramientas {
                align-items: stretch;

                flex-direction: column;
            }

            .filtro-form {
                width: 100%;
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

            .filtro-form {
                flex-direction: column;

                align-items: flex-start;
            }

            .filtro {
                width: 100%;
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


            <a
                href="{{ route('creditos.index') }}"
                class="activo"
            >

                @if(Auth::user()->rol === 'Administrador')
                    Créditos
                @else
                    Mis créditos
                @endif

            </a>


            <a href="{{ route('pagos.index') }}">

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
                        Créditos
                    @else
                        Mis créditos
                    @endif

                </h2>

                <p>

                    @if(Auth::user()->rol === 'Administrador')
                        Gestión de créditos del sistema
                    @else
                        Consulta de tus créditos
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
                        Gestión de Créditos
                    @else
                        Mis créditos
                    @endif

                </h1>


                <p>

                    @if(Auth::user()->rol === 'Administrador')
                        Administra los créditos registrados y consulta su estado.
                    @else
                        Consulta el estado, saldo y vencimiento de tus créditos.
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
                 HERRAMIENTAS
            ==================================== -->

            <div class="herramientas">


                <!-- FILTRO -->

                <form
                    action="{{ route('creditos.index') }}"
                    method="GET"
                    class="filtro-form"
                >

                    <label
                        for="estado"
                        class="filtro-label"
                    >
                        Filtrar por estado:
                    </label>


                    <select
                        name="estado"
                        id="estado"
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


                <!-- NUEVO CREDITO -->

                @if(Auth::user()->rol === 'Administrador')

                    <a
                        href="{{ route('creditos.create') }}"
                        class="btn btn-nuevo"
                    >
                        Nuevo crédito
                    </a>

                @endif


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

                            <th>Fecha otorgamiento</th>

                            <th>Monto</th>

                            <th>Interés</th>

                            <th>Total</th>

                            <th>Saldo pendiente</th>

                            <th>Vencimiento</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($creditos as $credito)

                            <tr>


                                <!-- ID -->

                                <td>
                                    {{ $credito->id }}
                                </td>


                                <!-- CLIENTE -->

                                <td>

                                    <strong>
                                        {{ $credito->cliente->nombres }}
                                        {{ $credito->cliente->apellidos }}
                                    </strong>

                                </td>


                                <!-- FECHA -->

                                <td>
                                    {{ $credito->fecha_otorgamiento->format('d/m/Y') }}
                                </td>


                                <!-- MONTO -->

                                <td>
                                    ${{ number_format($credito->monto, 2) }}
                                </td>


                                <!-- INTERES -->

                                <td>
                                    {{ $credito->tasa_interes }}%
                                </td>


                                <!-- TOTAL -->

                                <td>
                                    ${{ number_format($credito->total_credito, 2) }}
                                </td>


                                <!-- SALDO -->

                                <td>

                                    <span class="saldo">
                                        ${{ number_format($credito->saldo, 2) }}
                                    </span>

                                </td>


                                <!-- VENCIMIENTO -->

                                <td>
                                    {{ $credito->fecha_vencimiento->format('d/m/Y') }}
                                </td>


                                <!-- ESTADO -->

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
                                            {{ $credito->estado }}
                                        </span>

                                    @endif

                                </td>


                                <!-- ACCIONES -->

                                <td>

                                    <div class="acciones">


                                        <!-- VER -->

                                        <a
                                            href="{{ route('creditos.show', $credito) }}"
                                            class="btn btn-ver"
                                        >
                                            Ver
                                        </a>


                                        <!-- SOLO ADMIN -->

                                        @if(Auth::user()->rol === 'Administrador')


                                            <!-- EDITAR -->

                                            <a
                                                href="{{ route('creditos.edit', $credito) }}"
                                                class="btn btn-editar"
                                            >
                                                Editar
                                            </a>


                                            <!-- CANCELAR -->

                                            @if($credito->estado === 'Activo')

                                                <form
                                                    action="{{ route('creditos.destroy', $credito) }}"
                                                    method="POST"
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


                                    </div>

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


        </main>

    </div>

</div>

</body>

</html>