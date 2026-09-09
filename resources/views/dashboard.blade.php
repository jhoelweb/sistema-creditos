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
            background: #f4f6f9;
            color: #333;
        }

        /* ==============================
           BARRA SUPERIOR
        ============================== */

        .barra {
            background: #212529;
            color: white;
            padding: 18px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .barra h1 {
            font-size: 22px;
        }

        .usuario {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .usuario span {
            font-size: 14px;
        }

        .rol {
            background: #ffc107;
            color: #212529;

            padding: 5px 10px;
            border-radius: 15px;

            font-weight: bold;
        }

        .logout {
            background: #dc3545;
            color: white;

            border: none;
            padding: 9px 15px;

            border-radius: 6px;
            cursor: pointer;
        }

        .logout:hover {
            background: #bb2d3b;
        }

        /* ==============================
           CONTENEDOR
        ============================== */

        .contenedor {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ==============================
           BIENVENIDA
        ============================== */

        .bienvenida {
            background: white;

            padding: 25px;

            border-radius: 10px;

            margin-bottom: 25px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .bienvenida h2 {
            margin-bottom: 8px;
        }

        .bienvenida p {
            color: #666;
        }

        /* ==============================
           AVISO
        ============================== */

        .aviso {
            background: #e9ecef;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 25px;

            color: #555;
        }

        /* ==============================
           ESTADÍSTICAS
        ============================== */

        .estadisticas {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 30px;
        }

        .tarjeta {
            background: white;

            padding: 22px;

            border-radius: 10px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);

            border-left: 5px solid #007bff;
        }

        .tarjeta h3 {
            font-size: 14px;

            color: #666;

            margin-bottom: 10px;
        }

        .numero {
            font-size: 30px;

            font-weight: bold;

            color: #212529;
        }

        .descripcion {
            margin-top: 6px;

            font-size: 13px;

            color: #888;
        }

        .tarjeta.vencidos {
            border-left-color: #dc3545;
        }

        .tarjeta.saldo {
            border-left-color: #ffc107;
        }

        .tarjeta.pagos {
            border-left-color: #198754;
        }

        /* ==============================
           TÍTULO DE MÓDULOS
        ============================== */

        .titulo-modulos {
            margin-bottom: 20px;
        }

        .titulo-modulos h2 {
            font-size: 22px;
        }

        /* ==============================
           MÓDULOS
        ============================== */

        .modulos {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 20px;
        }

        .modulo {
            background: white;

            padding: 30px;

            border-radius: 10px;

            text-align: center;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);

            transition: transform 0.2s;
        }

        .modulo:hover {
            transform: translateY(-3px);
        }

        .icono {
            font-size: 40px;

            margin-bottom: 15px;
        }

        .modulo h3 {
            margin-bottom: 10px;
        }

        .modulo p {
            color: #666;

            margin-bottom: 20px;

            line-height: 1.5;
        }

        .boton {
            display: inline-block;

            text-decoration: none;

            background: #007bff;

            color: white;

            padding: 10px 18px;

            border-radius: 6px;
        }

        .boton:hover {
            background: #0056b3;
        }

        /* ==============================
           RESPONSIVE
        ============================== */

        @media (max-width: 900px) {

            .estadisticas {
                grid-template-columns: repeat(2, 1fr);
            }

            .modulos {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 600px) {

            .barra {
                flex-direction: column;

                gap: 15px;

                text-align: center;
            }

            .usuario {
                flex-direction: column;
            }

            .estadisticas {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<header class="barra">

    <h1>
        Sistema de Créditos
    </h1>

    <div class="usuario">

        <span>
            Usuario: {{ Auth::user()->name }}
        </span>

        <span class="rol">
            {{ Auth::user()->rol }}
        </span>

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button type="submit" class="logout">
                Cerrar sesión
            </button>

        </form>

    </div>

</header>


<main class="contenedor">


    <!-- ==============================
         BIENVENIDA
    ============================== -->

    <section class="bienvenida">

        <h2>
            Bienvenido, {{ Auth::user()->name }}
        </h2>

        <p>
            Panel principal del Sistema de Gestión de Créditos.
        </p>

    </section>


    <!-- ==============================
         MENSAJE SEGÚN ROL
    ============================== -->

    @if(Auth::user()->rol === 'Administrador')

        <div class="aviso">

            <strong>Panel de Administrador:</strong>

            tienes acceso completo a la administración del sistema.

        </div>

    @else

        <div class="aviso">

            <strong>Panel de Usuario:</strong>

            puedes consultar información y registrar pagos.

        </div>

    @endif


    <!-- ==============================
         ESTADÍSTICAS
    ============================== -->

    <section class="estadisticas">


        <div class="tarjeta">

            <h3>
                CLIENTES ACTIVOS
            </h3>

            <div class="numero">
                {{ $totalClientes }}
            </div>

            <div class="descripcion">
                Clientes registrados actualmente
            </div>

        </div>


        <div class="tarjeta">

            <h3>
                CRÉDITOS ACTIVOS
            </h3>

            <div class="numero">
                {{ $creditosActivos }}
            </div>

            <div class="descripcion">
                Créditos pendientes de pago
            </div>

        </div>


        <div class="tarjeta pagos">

            <h3>
                PAGOS REGISTRADOS
            </h3>

            <div class="numero">
                {{ $pagosRegistrados }}
            </div>

            <div class="descripcion">
                Pagos registrados en el sistema
            </div>

        </div>


        <div class="tarjeta saldo">

            <h3>
                SALDO PENDIENTE
            </h3>

            <div class="numero">
                ${{ number_format($saldoPendiente, 2) }}
            </div>

            <div class="descripcion">
                Total pendiente de cobro
            </div>

        </div>


        <div class="tarjeta vencidos">

            <h3>
                CRÉDITOS VENCIDOS
            </h3>

            <div class="numero">
                {{ $creditosVencidos }}
            </div>

            <div class="descripcion">
                Créditos que superaron su vencimiento
            </div>

        </div>


    </section>


    <!-- ==============================
         MÓDULOS
    ============================== -->

    <div class="titulo-modulos">

        <h2>
            Módulos del sistema
        </h2>

    </div>


    @if(Auth::user()->rol === 'Administrador')


        <section class="modulos">


            <div class="modulo">

                <div class="icono">
                    
                </div>

                <h3>
                    Clientes
                </h3>

                <p>
                    Registrar, consultar, editar y administrar clientes.
                </p>

                <a
                    href="{{ route('clientes.index') }}"
                    class="boton"
                >
                    Administrar clientes
                </a>

            </div>


            <div class="modulo">

                <div class="icono">
                    
                </div>

                <h3>
                    Créditos
                </h3>

                <p>
                    Registrar, consultar, editar y administrar créditos.
                </p>

                <a
                    href="{{ route('creditos.index') }}"
                    class="boton"
                >
                    Administrar créditos
                </a>

            </div>


            <div class="modulo">

                <div class="icono">
                    
                </div>

                <h3>
                    Pagos
                </h3>

                <p>
                    Registrar y consultar los pagos realizados.
                </p>

                <a
                    href="{{ route('pagos.index') }}"
                    class="boton"
                >
                    Administrar pagos
                </a>

            </div>


        </section>


    @else


        <section class="modulos">


            <div class="modulo">

                <div class="icono">
                    
                </div>

                <h3>
                    Clientes
                </h3>

                <p>
                    Consultar la información de los clientes registrados.
                </p>

                <a
                    href="{{ route('clientes.index') }}"
                    class="boton"
                >
                    Consultar clientes
                </a>

            </div>


            <div class="modulo">

                <div class="icono">
                    
                </div>

                <h3>
                    Créditos
                </h3>

                <p>
                    Consultar créditos, estados y saldos pendientes.
                </p>

                <a
                    href="{{ route('creditos.index') }}"
                    class="boton"
                >
                    Consultar créditos
                </a>

            </div>


            <div class="modulo">

                <div class="icono">
                    
                </div>

                <h3>
                    Pagos
                </h3>

                <p>
                    Consultar y registrar pagos de créditos.
                </p>

                <a
                    href="{{ route('pagos.index') }}"
                    class="boton"
                >
                    Consultar pagos
                </a>

            </div>


        </section>


    @endif


</main>

</body>

</html>