<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Categorias</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #14243a;
            font-size: 12px;
            margin: 28px 32px;
        }

        .report-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .report-date {
            color: #62748a;
            font-size: 11px;
            margin-bottom: 14px;
        }

        .report-rule {
            border: 0;
            border-top: 3px solid #2f5eb9;
            margin: 0 0 18px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 -10px 16px;
        }

        .summary-card {
            border: 1px solid #cddbf8;
            border-radius: 10px;
            padding: 12px 14px;
            background: #f7faff;
        }

        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #4967d4;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #14243a;
        }

        .catalog-title {
            font-size: 18px;
            font-weight: 700;
            margin: 8px 0 12px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            background: #2e448f;
            color: #ffffff;
            text-align: left;
            padding: 10px 8px;
            font-size: 10px;
            text-transform: uppercase;
        }

        .data-table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #d8e2f0;
            vertical-align: top;
            line-height: 1.45;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f8fbff;
        }

        .state-pill {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            color: #1f5135;
            background: #ddf7e6;
        }

        .state-pill.inactive {
            color: #6a4f15;
            background: #fff1cf;
        }
    </style>
</head>
<body>
    <h1 class="report-title">Reporte de Categorias</h1>
    <div class="report-date">Fecha de generacion: {{ $fechaGeneracion->format('d/m/Y H:i') }}</div>
    <hr class="report-rule">

    <table class="summary-table">
        <tr>
            <td width="33.33%">
                <div class="summary-card">
                    <div class="summary-label">Total categorias</div>
                    <div class="summary-value">{{ $categorias->count() }}</div>
                </div>
            </td>
            <td width="33.33%">
                <div class="summary-card">
                    <div class="summary-label">Categorias activas</div>
                    <div class="summary-value">{{ $categorias->where('estado', true)->count() }}</div>
                </div>
            </td>
            <td width="33.33%">
                <div class="summary-card">
                    <div class="summary-label">Categorias inactivas</div>
                    <div class="summary-value">{{ $categorias->where('estado', false)->count() }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="catalog-title">Detalle completo del catalogo de categorias</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="7%">Nro</th>
                <th width="26%">Nombre</th>
                <th width="49%">Descripcion</th>
                <th width="18%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $categoria->nombre }}</td>
                    <td>{{ $categoria->descripcion ?: 'Sin descripcion registrada.' }}</td>
                    <td>
                        <span class="state-pill {{ $categoria->estado ? '' : 'inactive' }}">
                            {{ $categoria->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay categorias registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
