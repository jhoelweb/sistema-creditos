<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recibo de Pago #{{ $pago->id }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .recibo {
            width: 100%;
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .encabezado {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .encabezado h1 {
            margin: 0;
            color: #2563eb;
            font-size: 28px;
        }

        .encabezado p {
            margin: 8px 0 0;
            color: #64748b;
        }

        .numero-recibo {
            text-align: right;
            margin-bottom: 25px;
            font-size: 14px;
            color: #475569;
        }

        .seccion {
            margin-bottom: 25px;
        }

        .seccion h2 {
            font-size: 17px;
            margin-bottom: 12px;
            color: #1e40af;
        }

        .dato {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .dato strong {
            color: #475569;
        }

        .monto {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }

        .monto span {
            display: block;
            color: #64748b;
            margin-bottom: 8px;
        }

        .monto strong {
            font-size: 32px;
            color: #2563eb;
        }

        .estado {
            text-align: center;
            margin: 25px 0;
        }

        .estado span {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
        }

        .acciones {
            text-align: center;
            margin-top: 30px;
        }

        .boton {
            display: inline-block;
            padding: 11px 18px;
            margin: 5px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .volver {
            background: #64748b;
            color: white;
        }

        .imprimir {
            background: #2563eb;
            color: white;
        }

        .pie {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .recibo {
                max-width: 100%;
                box-shadow: none;
                border-radius: 0;
            }

            .acciones {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .recibo {
                padding: 25px;
            }

            .dato {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>

<body>

    <div class="recibo">

        <div class="encabezado">
            <h1>Sistema de Gestión de Créditos</h1>
            <p>Comprobante de pago</p>
        </div>

        <div class="numero-recibo">
            <strong>Recibo #{{ $pago->id }}</strong>
        </div>

        <div class="seccion">

            <h2>Información del cliente</h2>

            <div class="dato">
                <strong>Cliente:</strong>
                <span>
                    {{ $pago->credito->cliente->nombres }}
                    {{ $pago->credito->cliente->apellidos }}
                </span>
            </div>

            <div class="dato">
                <strong>Documento:</strong>
                <span>
                    {{ $pago->credito->cliente->documento_identidad }}
                </span>
            </div>

        </div>

        <div class="seccion">

            <h2>Información del crédito</h2>

            <div class="dato">
                <strong>Crédito:</strong>
                <span>#{{ $pago->credito->id }}</span>
            </div>

            <div class="dato">
                <strong>Monto original:</strong>
                <span>
                    ${{ number_format($pago->credito->monto, 2) }}
                </span>
            </div>

            <div class="dato">
                <strong>Total del crédito:</strong>
                <span>
                    ${{ number_format($pago->credito->total_credito, 2) }}
                </span>
            </div>

        </div>

        <div class="seccion">

            <h2>Información del pago</h2>

            <div class="dato">
                <strong>Fecha de pago:</strong>
                <span>
                    {{ $pago->fecha_pago->format('d/m/Y') }}
                </span>
            </div>

            <div class="dato">
                <strong>Referencia:</strong>
                <span>
                    {{ $pago->referencia ?? 'Sin referencia' }}
                </span>
            </div>

        </div>

        <div class="monto">
            <span>Monto pagado</span>

            <strong>
                ${{ number_format($pago->monto, 2) }}
            </strong>
        </div>

        <div class="seccion">

            <div class="dato">
                <strong>Saldo pendiente:</strong>

                <span>
                    ${{ number_format($pago->credito->saldo, 2) }}
                </span>
            </div>

            <div class="dato">
                <strong>Estado del crédito:</strong>

                <span>
                    {{ $pago->credito->estado }}
                </span>
            </div>

            <div class="dato">
                <strong>Observaciones:</strong>

                <span>
                    {{ $pago->observaciones ?? 'Sin observaciones' }}
                </span>
            </div>

        </div>

        <div class="estado">
            <span>Pago registrado correctamente</span>
        </div>

        <div class="acciones">

            <a href="{{ route('pagos.show', $pago) }}" class="boton volver">
                Volver
            </a>

            <button onclick="window.print()" class="boton imprimir">
                🖨️ Imprimir recibo
            </button>

        </div>

        <div class="pie">
            Este documento es un comprobante generado por el Sistema de Gestión de Créditos.
        </div>

    </div>

</body>

</html>