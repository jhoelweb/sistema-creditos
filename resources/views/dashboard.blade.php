<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Sistema de Créditos</title>

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
           ESTRUCTURA PRINCIPAL
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
           NAVEGACION
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
            height: 72px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
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
           AREA PRINCIPAL
        ======================================== */

        .principal {
            padding: 35px;
        }


        /* ========================================
           BIENVENIDA
        ======================================== */

        .bienvenida {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 28px;
        }

        .bienvenida h1 {
            font-size: 25px;
            margin-bottom: 8px;
        }

        .bienvenida p {
            color: #6b7280;
            font-size: 14px;
        }


        /* ========================================
           ESTADISTICAS
        ======================================== */

        .estadisticas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 35px;
        }

        .tarjeta {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 22px;
            min-height: 130px;
        }

        .tarjeta-titulo {
            color: #6b7280;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .numero {
            font-size: 28px;
            font-weight: bold;
            color: #111827;
        }

        .descripcion {
            margin-top: 7px;
            color: #9ca3af;
            font-size: 12px;
        }

        .tarjeta.azul {
            border-top: 3px solid #2563eb;
        }

        .tarjeta.verde {
            border-top: 3px solid #198754;
        }

        .tarjeta.amarilla {
            border-top: 3px solid #f59e0b;
        }

        .tarjeta.roja {
            border-top: 3px solid #dc3545;
        }


        /* ========================================
           TITULO SECCION
        ======================================== */

        .seccion-titulo {
            margin-bottom: 18px;
        }

        .seccion-titulo h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .seccion-titulo p {
            color: #6b7280;
            font-size: 13px;
            margin-top: 5px;
        }


        /* ========================================
           MODULOS
        ======================================== */

        .modulos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .modulo {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 25px;
            transition: 0.2s;
        }

        .modulo:hover {
            border-color: #cbd5e1;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        .modulo h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .modulo p {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
            min-height: 40px;
            margin-bottom: 20px;
        }

        .boton {
            display: inline-block;
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
        }

        .boton:hover {
            background: #1d4ed8;
        }


        /* ========================================
           MENSAJE DE ROL
        ======================================== */

        .aviso {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1e40af;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 28px;
            font-size: 13px;
        }


        /* ========================================
           RESPONSIVE
        ======================================== */

        @media (max-width: 1100px) {

            .estadisticas {
                grid-template-columns: repeat(2, 1fr);
            }

            .modulos {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        @media (max-width: 800px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .layout {
                display: block;
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
                height: auto;
                padding: 20px;
                gap: 15px;
            }

            .principal {
                padding: 20px;
            }

        }


        @media (max-width: 600px) {

            .estadisticas {
                grid-template-columns: 1fr;
            }

            .modulos {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .usuario {
                width: 100%;
                justify-content: space-between;
            }

            .usuario-info {
                text-align: left;
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

            <a
                href="{{ route('dashboard') }}"
                class="activo"
            >
                Dashboard
            </a>


            @if(Auth::user()->rol === 'Administrador')

                <a href="{{ route('clientes.index') }}">
                    Clientes
                </a>

                <a href="{{ route('creditos.index') }}">
                    Créditos
                </a>

                <a href="{{ route('pagos.index') }}">
                    Pagos
                </a>

            @else

                <a href="{{ route('clientes.index') }}">
                    Mi información
                </a>

                <a href="{{ route('creditos.index') }}">
                    Mis créditos
                </a>

                <a href="{{ route('pagos.index') }}">
                    Mis pagos
                </a>

            @endif

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

                <h2>Dashboard</h2>

                <p>Panel principal del sistema</p>

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


            <!-- BIENVENIDA -->

            <section class="bienvenida">

                <h1>
                    Bienvenido, {{ Auth::user()->name }}
                </h1>

                <p>
                    Consulta y administra la información correspondiente a tu cuenta.
                </p>

            </section>


            <!-- ====================================
                 MENSAJE SEGÚN ROL
            ==================================== -->

            @if(Auth::user()->rol === 'Administrador')

                <div class="aviso">

                    <strong>Panel de Administrador.</strong>

                    Tienes acceso completo a la gestión de clientes,
                    créditos y pagos.

                </div>

            @else

                <div class="aviso">

                    <strong>Panel de Cliente.</strong>

                    Desde aquí puedes consultar tu información,
                    tus créditos y tus pagos.

                </div>

            @endif


            <!-- ====================================
                 ESTADISTICAS
            ==================================== -->

            <section class="estadisticas">


                @if(Auth::user()->rol === 'Administrador')


                    <!-- CLIENTES -->

                    <div class="tarjeta azul">

                        <div class="tarjeta-titulo">
                            Clientes activos
                        </div>

                        <div class="numero">
                            {{ $totalClientes }}
                        </div>

                        <div class="descripcion">
                            Clientes registrados actualmente
                        </div>

                    </div>


                    <!-- CREDITOS -->

                    <div class="tarjeta azul">

                        <div class="tarjeta-titulo">
                            Créditos activos
                        </div>

                        <div class="numero">
                            {{ $creditosActivos }}
                        </div>

                        <div class="descripcion">
                            Créditos pendientes de pago
                        </div>

                    </div>


                    <!-- PAGOS -->

                    <div class="tarjeta verde">

                        <div class="tarjeta-titulo">
                            Pagos registrados
                        </div>

                        <div class="numero">
                            {{ $pagosRegistrados }}
                        </div>

                        <div class="descripcion">
                            Pagos registrados en el sistema
                        </div>

                    </div>


                    <!-- SALDO -->

                    <div class="tarjeta amarilla">

                        <div class="tarjeta-titulo">
                            Saldo pendiente
                        </div>

                        <div class="numero">
                            ${{ number_format($saldoPendiente, 2) }}
                        </div>

                        <div class="descripcion">
                            Total pendiente de cobro
                        </div>

                    </div>


                    <!-- VENCIDOS -->

                    <div class="tarjeta roja">

                        <div class="tarjeta-titulo">
                            Créditos vencidos
                        </div>

                        <div class="numero">
                            {{ $creditosVencidos }}
                        </div>

                        <div class="descripcion">
                            Créditos que superaron su vencimiento
                        </div>

                    </div>


                @else


                    <!-- CLIENTE -->

                    <div class="tarjeta azul">

                        <div class="tarjeta-titulo">
                            Mi cuenta
                        </div>

                        <div class="numero">
                            Activa
                        </div>

                        <div class="descripcion">
                            Cuenta asociada a tu información
                        </div>

                    </div>


                    <!-- CREDITOS -->

                    <div class="tarjeta azul">

                        <div class="tarjeta-titulo">
                            Mis créditos activos
                        </div>

                        <div class="numero">
                            {{ $creditosActivos }}
                        </div>

                        <div class="descripcion">
                            Créditos pendientes de pago
                        </div>

                    </div>


                    <!-- PAGOS -->

                    <div class="tarjeta verde">

                        <div class="tarjeta-titulo">
                            Mis pagos
                        </div>

                        <div class="numero">
                            {{ $pagosRegistrados }}
                        </div>

                        <div class="descripcion">
                            Pagos registrados por ti
                        </div>

                    </div>


                    <!-- SALDO -->

                    <div class="tarjeta amarilla">

                        <div class="tarjeta-titulo">
                            Saldo pendiente
                        </div>

                        <div class="numero">
                            ${{ number_format($saldoPendiente, 2) }}
                        </div>

                        <div class="descripcion">
                            Saldo pendiente de tus créditos
                        </div>

                    </div>


                    <!-- VENCIDOS -->

                    <div class="tarjeta roja">

                        <div class="tarjeta-titulo">
                            Créditos vencidos
                        </div>

                        <div class="numero">
                            {{ $creditosVencidos }}
                        </div>

                        <div class="descripcion">
                            Tus créditos vencidos
                        </div>

                    </div>


                @endif


            </section>


            <!-- ====================================
                 MODULOS
            ==================================== -->

            <section>

                <div class="seccion-titulo">

                    @if(Auth::user()->rol === 'Administrador')

                        <h2>Administración del sistema</h2>

                        <p>
                            Accede a los principales módulos de gestión.
                        </p>

                    @else

                        <h2>Mis opciones</h2>

                        <p>
                            Consulta y gestiona la información disponible para tu cuenta.
                        </p>

                    @endif

                </div>


                <div class="modulos">


                    @if(Auth::user()->rol === 'Administrador')


                        <!-- CLIENTES -->

                        <div class="modulo">

                            <h3>Clientes</h3>

                            <p>
                                Registrar, consultar, editar y administrar
                                los clientes del sistema.
                            </p>

                            <a
                                href="{{ route('clientes.index') }}"
                                class="boton"
                            >
                                Administrar clientes
                            </a>

                        </div>


                        <!-- CREDITOS -->

                        <div class="modulo">

                            <h3>Créditos</h3>

                            <p>
                                Registrar créditos, consultar saldos,
                                estados y fechas de vencimiento.
                            </p>

                            <a
                                href="{{ route('creditos.index') }}"
                                class="boton"
                            >
                                Administrar créditos
                            </a>

                        </div>


                        <!-- PAGOS -->

                        <div class="modulo">

                            <h3>Pagos</h3>

                            <p>
                                Registrar pagos, consultar movimientos
                                y generar recibos.
                            </p>

                            <a
                                href="{{ route('pagos.index') }}"
                                class="boton"
                            >
                                Administrar pagos
                            </a>

                        </div>


                    @else


                        <!-- INFORMACION -->

                        <div class="modulo">

                            <h3>Mi información</h3>

                            <p>
                                Consulta tus datos personales registrados
                                en el sistema.
                            </p>

                            <a
                                href="{{ route('clientes.index') }}"
                                class="boton"
                            >
                                Consultar información
                            </a>

                        </div>


                        <!-- CREDITOS -->

                        <div class="modulo">

                            <h3>Mis créditos</h3>

                            <p>
                                Consulta tus créditos, saldos,
                                estados y fechas de vencimiento.
                            </p>

                            <a
                                href="{{ route('creditos.index') }}"
                                class="boton"
                            >
                                Consultar créditos
                            </a>

                        </div>


                        <!-- PAGOS -->

                        <div class="modulo">

                            <h3>Mis pagos</h3>

                            <p>
                                Consulta tus pagos, registra nuevos
                                pagos y genera tus recibos.
                            </p>

                            <a
                                href="{{ route('pagos.index') }}"
                                class="boton"
                            >
                                Consultar pagos
                            </a>

                        </div>


                    @endif


                </div>

            </section>


        </main>

    </div>

</div>

</body>

</html>