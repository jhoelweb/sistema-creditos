<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Pago - Sistema de Créditos</title>

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

        .layout {
            min-height: 100vh;
            display: flex;
        }


        /* SIDEBAR */

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


        /* MENU */

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


        /* CONTENIDO */

        .contenido {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }


        /* TOPBAR */

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


        /* PRINCIPAL */

        .principal {
            padding: 35px;
        }

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


        /* FORMULARIO */

        .formulario {
            max-width: 750px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 30px;
        }

        .grupo {
            margin-bottom: 20px;
        }

        .grupo label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .grupo input,
        .grupo textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .grupo input:focus,
        .grupo textarea:focus {
            border-color: #2563eb;
        }

        .grupo textarea {
            min-height: 110px;
            resize: vertical;
        }

        .credito-info {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .credito-info p {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .credito-info p:last-child {
            margin-bottom: 0;
        }

        .credito-info strong {
            display: inline-block;
            width: 180px;
        }


        /* ERRORES */

        .errores {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .errores ul {
            margin-left: 20px;
        }

        .errores li {
            margin-bottom: 4px;
            font-size: 13px;
        }


        /* BOTONES */

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-guardar {
            background: #2563eb;
            color: white;
        }

        .btn-guardar:hover {
            background: #1d4ed8;
        }

        .btn-cancelar {
            background: #6b7280;
            color: white;
        }

        .btn-cancelar:hover {
            background: #4b5563;
        }


        /* RESPONSIVE */

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

            .formulario {
                padding: 20px;
            }

            .acciones {
                flex-direction: column;
            }

            .acciones .btn {
                text-align: center;
            }

        }

    </style>

</head>


<body>

<div class="layout">


    <!-- SIDEBAR -->

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
                Clientes
            </a>

            <a href="{{ route('creditos.index') }}">
                Créditos
            </a>

            <a
                href="{{ route('pagos.index') }}"
                class="activo"
            >
                Pagos
            </a>

        </nav>

    </aside>


    <!-- CONTENIDO -->

    <div class="contenido">


        <!-- TOPBAR -->

        <header class="topbar">

            <div class="topbar-titulo">

                <h2>
                    Editar pago
                </h2>

                <p>
                    Modificación de un pago registrado
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


        <!-- PRINCIPAL -->

        <main class="principal">


            <div class="encabezado">

                <h1>
                    Editar pago #{{ $pago->id }}
                </h1>

                <p>
                    Actualiza la información del pago seleccionado.
                </p>

            </div>


            <!-- ERRORES -->

            @if($errors->any())

                <div class="errores">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- INFORMACIÓN DEL CRÉDITO -->

            <div class="formulario">

                <div class="credito-info">

                    <p>

                        <strong>Cliente:</strong>

                        {{ $pago->credito->cliente->nombres }}
                        {{ $pago->credito->cliente->apellidos }}

                    </p>


                    <p>

                        <strong>Crédito:</strong>

                        #{{ $pago->credito_id }}

                    </p>


                    <p>

                        <strong>Total del crédito:</strong>

                        ${{ number_format($pago->credito->total_credito, 2) }}

                    </p>


                    <p>

                        <strong>Saldo actual:</strong>

                        ${{ number_format($pago->credito->saldo, 2) }}

                    </p>

                </div>


                <!-- FORMULARIO -->

                <form
                    action="{{ route('pagos.update', $pago) }}"
                    method="POST"
                >

                    @csrf

                    @method('PUT')


                    <!-- FECHA -->

                    <div class="grupo">

                        <label for="fecha_pago">
                            Fecha del pago
                        </label>

                        <input
                            type="date"
                            id="fecha_pago"
                            name="fecha_pago"
                            value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d')) }}"
                            required
                        >

                    </div>


                    <!-- MONTO -->

                    <div class="grupo">

                        <label for="monto">
                            Monto del pago
                        </label>

                        <input
                            type="number"
                            id="monto"
                            name="monto"
                            step="0.01"
                            min="0.01"
                            value="{{ old('monto', $pago->monto) }}"
                            required
                        >

                    </div>


                    <!-- REFERENCIA -->

                    <div class="grupo">

                        <label for="referencia">
                            Referencia
                        </label>

                        <input
                            type="text"
                            id="referencia"
                            name="referencia"
                            maxlength="100"
                            value="{{ old('referencia', $pago->referencia) }}"
                        >

                    </div>


                    <!-- OBSERVACIONES -->

                    <div class="grupo">

                        <label for="observaciones">
                            Observaciones
                        </label>

                        <textarea
                            id="observaciones"
                            name="observaciones"
                            maxlength="500"
                        >{{ old('observaciones', $pago->observaciones) }}</textarea>

                    </div>


                    <!-- ACCIONES -->

                    <div class="acciones">

                        <button
                            type="submit"
                            class="btn btn-guardar"
                        >
                            Guardar cambios
                        </button>


                        <a
                            href="{{ route('pagos.index') }}"
                            class="btn btn-cancelar"
                        >
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>


        </main>

    </div>

</div>

</body>

</html>