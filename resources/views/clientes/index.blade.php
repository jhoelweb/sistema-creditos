<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes - Sistema de Créditos</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;

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

        .busqueda {
            display: flex;

            gap: 10px;

            flex: 1;
        }

        .busqueda input {
            width: 100%;

            max-width: 400px;

            padding: 11px 13px;

            border: 1px solid #d1d5db;

            border-radius: 6px;

            font-size: 14px;

            outline: none;
        }

        .busqueda input:focus {
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

        .btn-buscar {
            background: #2563eb;
            color: white;
        }

        .btn-buscar:hover {
            background: #1d4ed8;
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

        .btn-desactivar {
            background: #dc3545;
            color: white;
        }

        .btn-desactivar:hover {
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

            min-width: 850px;
        }

        th {
            background: #1f2937;

            color: white;

            padding: 14px 15px;

            text-align: left;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 0.3px;
        }

        td {
            padding: 14px 15px;

            border-bottom: 1px solid #e5e7eb;

            font-size: 13px;

            color: #374151;
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

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }

        .activo {
            background: #d1e7dd;

            color: #0f5132;
        }

        .inactivo {
            background: #f8d7da;

            color: #842029;
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

            padding: 35px;

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

            .busqueda {
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

            .encabezado {
                flex-direction: column;

                align-items: flex-start;

                gap: 10px;
            }

            .principal {
                padding: 20px;
            }

        }


        @media (max-width: 500px) {

            .busqueda {
                flex-direction: column;
            }

            .busqueda input {
                max-width: none;
            }

            .acciones {
                flex-direction: column;

                align-items: flex-start;
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

            <a
                href="{{ route('clientes.index') }}"
                class="activo"
            >

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
                        Clientes
                    @else
                        Mi información
                    @endif
                </h2>

                <p>
                    @if(Auth::user()->rol === 'Administrador')
                        Gestión de clientes del sistema
                    @else
                        Información de tu cuenta
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
             CONTENIDO PRINCIPAL
        ==================================== -->

        <main class="principal">


            <!-- ENCABEZADO -->

            <div class="encabezado">

                <div>

                    <h1>

                        @if(Auth::user()->rol === 'Administrador')
                            Gestión de Clientes
                        @else
                            Mi información
                        @endif

                    </h1>

                    <p>

                        @if(Auth::user()->rol === 'Administrador')
                            Administra los clientes registrados en el sistema.
                        @else
                            Consulta la información asociada a tu cuenta.
                        @endif

                    </p>

                </div>

            </div>


            <!-- ====================================
                 MENSAJE DE ÉXITO
            ==================================== -->

            @if(session('success'))

                <div class="mensaje">

                    {{ session('success') }}

                </div>

            @endif


            <!-- ====================================
                 HERRAMIENTAS
            ==================================== -->

            @if(Auth::user()->rol === 'Administrador')

                <div class="herramientas">

                    <form
                        action="{{ route('clientes.index') }}"
                        method="GET"
                        class="busqueda"
                    >

                        <input
                            type="text"
                            name="buscar"
                            placeholder="Buscar por nombre, documento o teléfono..."
                            value="{{ $buscar ?? '' }}"
                        >

                        <button
                            type="submit"
                            class="btn btn-buscar"
                        >
                            Buscar
                        </button>

                    </form>


                    <a
                        href="{{ route('clientes.create') }}"
                        class="btn btn-nuevo"
                    >
                        Nuevo cliente
                    </a>

                </div>

            @endif


            <!-- ====================================
                 TABLA
            ==================================== -->

            <div class="tabla-contenedor">

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Nombre</th>

                            <th>Documento</th>

                            <th>Teléfono</th>

                            <th>Correo</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($clientes as $cliente)

                            <tr>

                                <td>
                                    {{ $cliente->id }}
                                </td>


                                <td>

                                    <strong>
                                        {{ $cliente->nombres }}
                                        {{ $cliente->apellidos }}
                                    </strong>

                                </td>


                                <td>
                                    {{ $cliente->documento_identidad }}
                                </td>


                                <td>
                                    {{ $cliente->telefono }}
                                </td>


                                <td>
                                    {{ $cliente->correo }}
                                </td>


                                <td>

                                    @if($cliente->estado)

                                        <span class="estado activo">
                                            Activo
                                        </span>

                                    @else

                                        <span class="estado inactivo">
                                            Inactivo
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <div class="acciones">


                                        <!-- VER -->

                                        <a
                                            href="{{ route('clientes.show', $cliente) }}"
                                            class="btn btn-ver"
                                        >
                                            Ver
                                        </a>


                                        <!-- SOLO ADMIN -->

                                        @if(Auth::user()->rol === 'Administrador')


                                            <!-- EDITAR -->

                                            <a
                                                href="{{ route('clientes.edit', $cliente) }}"
                                                class="btn btn-editar"
                                            >
                                                Editar
                                            </a>


                                            <!-- DESACTIVAR -->

                                            @if($cliente->estado)

                                                <form
                                                    action="{{ route('clientes.destroy', $cliente) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-desactivar"
                                                        onclick="return confirm('¿Deseas desactivar este cliente?')"
                                                    >
                                                        Desactivar
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
                                    colspan="7"
                                    class="sin-resultados"
                                >
                                    No hay clientes registrados.
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