<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Sistema de Créditos</title>

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
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            width: 300px;
        }

        button,
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-nuevo {
            background: #198754;
            color: white;
        }

        .btn-editar {
            background: #ffc107;
            color: black;
        }

        .btn-ver {
            background: #0d6efd;
            color: white;
        }

        .btn-desactivar {
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

        .inactivo {
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
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Gestión de Clientes</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mensaje">
            {{ session('success') }}
        </div>
    @endif

    {{-- Buscador --}}
    <form action="{{ route('clientes.index') }}" method="GET">
        <div class="barra">

            <input
                type="text"
                name="buscar"
                placeholder="Buscar cliente..."
                value="{{ $buscar ?? '' }}"
            >

            <button type="submit">
                Buscar
            </button>

            <a href="{{ route('clientes.create') }}" class="btn btn-nuevo">
                Nuevo cliente
            </a>

        </div>
    </form>

    {{-- Tabla --}}
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
                    <td>{{ $cliente->id }}</td>

                    <td>
                        {{ $cliente->nombres }}
                        {{ $cliente->apellidos }}
                    </td>

                    <td>{{ $cliente->documento_identidad }}</td>

                    <td>{{ $cliente->telefono }}</td>

                    <td>{{ $cliente->correo }}</td>

                    <td>
                        @if($cliente->estado)
                            <span class="activo">Activo</span>
                        @else
                            <span class="inactivo">Inactivo</span>
                        @endif
                    </td>

                    <td>

                        <a
                            href="{{ route('clientes.show', $cliente) }}"
                            class="btn btn-ver"
                        >
                            Ver
                        </a>

                        <a
                            href="{{ route('clientes.edit', $cliente) }}"
                            class="btn btn-editar"
                        >
                            Editar
                        </a>

                        @if($cliente->estado)

                            <form
                                action="{{ route('clientes.destroy', $cliente) }}"
                                method="POST"
                                style="display:inline;"
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

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">
                        No hay clientes registrados.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>
</html>