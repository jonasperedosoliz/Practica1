<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        @page {
            margin: 26px 24px 24px 24px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #243447;
            margin: 0;
            line-height: 1.45;
            background: #ffffff;
        }

        .report-shell {
            width: 100%;
        }

        .report-header {
            border-radius: 18px;
            background: #1f4d7e;
            color: #ffffff;
            padding: 40px 30px 30px 30px;
            margin-bottom: 10px;
            border: 1px solid #163a61;
        }

        .report-kicker {
            display: block;
            margin-bottom: 10px;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .eyebrow {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #dbeafe;
            margin-bottom: 12px;
        }

        .report-title {
            margin: 0;
            font-size: 40px;
            line-height: 1.05;
            letter-spacing: 0.02em;
            color: #ffffff;
        }

        .report-subtitle {
            margin: 10px 0 0 0;
            font-size: 14px;
            color: #eaf3ff;
        }

        .report-meta {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #93b8df;
            font-size: 12px;
            color: #f8fbff;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 0 10px 0;
        }

        .summary-card {
            background: #f8fbff;
            border: 1px solid #d8e5f3;
            border-top: 4px solid #2f7cc0;
            border-radius: 12px;
            padding: 12px 14px;
            vertical-align: top;
        }

        .summary-card-green {
            border-top-color: #1f9d68;
            background: #f5fcf8;
        }

        .summary-card-orange {
            border-top-color: #ea9b1f;
            background: #fffaf2;
        }

        .summary-label {
            display: block;
            color: #5f7187;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .summary-value {
            display: block;
            color: #122033;
            font-size: 20px;
            font-weight: bold;
            line-height: 1.1;
        }

        .summary-note {
            display: block;
            color: #6d7f92;
            font-size: 10px;
            margin-top: 4px;
        }

        .section-bar {
            margin: 0 0 10px 0;
            padding: 10px 14px;
            background: #f4f8fc;
            border: 1px solid #d8e5f3;
            color: #1d3554;
            font-size: 12px;
            font-weight: bold;
            border-radius: 10px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.report thead th {
            background: #1f4d7e;
            color: #ffffff;
            text-align: left;
            font-size: 10px;
            padding: 9px 8px;
            border: 1px solid #d8e5f3;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        table.report tbody td {
            border: 1px solid #dce6ef;
            padding: 8px 8px;
            vertical-align: top;
            word-wrap: break-word;
        }

        table.report tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        table.report tbody tr:nth-child(even) {
            background: #f8fbfe;
        }

        .id-cell,
        .stock-cell {
            text-align: center;
            font-weight: bold;
            color: #26415f;
        }

        .price-cell,
        .subtotal-cell {
            text-align: right;
            white-space: nowrap;
            font-weight: bold;
            color: #173454;
        }

        .product-name {
            font-weight: bold;
            color: #132238;
            margin-bottom: 2px;
        }

        .product-media {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #d9e4ef;
            background: #f4f7fb;
            text-align: center;
            line-height: 42px;
            color: #69809a;
            font-size: 9px;
            margin-bottom: 6px;
        }

        .product-media img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            display: block;
        }

        .product-description {
            color: #55677b;
            font-size: 10px;
        }

        .category-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            background: #edf5ff;
            color: #295785;
            font-size: 10px;
            font-weight: bold;
        }

        .empty-state {
            text-align: center;
            color: #6b7d8f;
            padding: 18px 0;
        }

        .report-footer {
            margin-top: 16px;
            padding-top: 10px;
            border-top: 1px solid #d8e5f3;
            font-size: 10px;
            color: #6d7f92;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="report-shell">
        <div class="report-header">
            <div class="report-kicker">Reporte Productos</div>
            <div class="eyebrow">Practica 1 · Modulo productos</div>
            <h1 class="report-title">Reporte general de productos</h1>
            <p class="report-subtitle">
                Resumen consolidado del inventario con detalle por producto, categoria, precio, stock y subtotal.
            </p>
            <div class="report-meta">
                Fecha de generacion: {{ $fechaGeneracion->format('d/m/Y H:i') }}
            </div>
        </div>

        <table class="summary-table">
            <tr>
                <td class="summary-card" style="width: 33.33%;">
                    <span class="summary-label">Total de productos</span>
                    <span class="summary-value">{{ $productos->count() }}</span>
                    <span class="summary-note">Registros incluidos en este reporte</span>
                </td>
                <td class="summary-card summary-card-green" style="width: 33.33%;">
                    <span class="summary-label">Stock acumulado</span>
                    <span class="summary-value">{{ $productos->sum('stock') }}</span>
                    <span class="summary-note">Unidades disponibles en inventario</span>
                </td>
                <td class="summary-card summary-card-orange" style="width: 33.33%;">
                    <span class="summary-label">Valor total del inventario</span>
                    <span class="summary-value">{{ number_format($productos->sum(fn ($producto) => $producto->precio * $producto->stock), 2) }} Bs</span>
                    <span class="summary-note">Monto estimado segun precio por stock</span>
                </td>
            </tr>
        </table>

        <div class="section-bar">Detalle completo del catalogo de productos</div>

        <table class="report">
            <thead>
                <tr>
                    <th style="width: 7%;">Numero</th>
                    <th style="width: 22%;">Producto</th>
                    <th style="width: 22%;">Descripcion</th>
                    <th style="width: 16%;">Categoria</th>
                    <th style="width: 11%;">Precio</th>
                    <th style="width: 9%;">Stock</th>
                    <th style="width: 13%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td class="id-cell">{{ $loop->iteration }}</td>
                        <td>
                            @php
                                $rutaImagen = $producto->imagen ? public_path('storage/'.$producto->imagen) : null;
                                $imagenEmbebida = null;

                                if ($rutaImagen && file_exists($rutaImagen)) {
                                    $extension = strtolower(pathinfo($rutaImagen, PATHINFO_EXTENSION) ?: 'jpeg');
                                    $mime = match ($extension) {
                                        'png' => 'image/png',
                                        'webp' => 'image/webp',
                                        'gif' => 'image/gif',
                                        default => 'image/jpeg',
                                    };

                                    $contenido = @file_get_contents($rutaImagen);

                                    if ($contenido !== false) {
                                        $imagenEmbebida = 'data:'.$mime.';base64,'.base64_encode($contenido);
                                    }
                                }
                            @endphp
                            <div class="product-media">
                                @if($imagenEmbebida)
                                    <img src="{{ $imagenEmbebida }}" alt="Imagen">
                                @else
                                    Img
                                @endif
                            </div>
                            <div class="product-name">{{ $producto->nombre }}</div>
                        </td>
                        <td>
                            <div class="product-description">{{ $producto->descripcion ?: 'Sin descripcion registrada' }}</div>
                        </td>
                        <td>
                            <span class="category-badge">{{ $producto->categoria->nombre ?? 'Sin categoria' }}</span>
                        </td>
                        <td class="price-cell">{{ number_format((float) $producto->precio, 2) }} Bs</td>
                        <td class="stock-cell">{{ $producto->stock }}</td>
                        <td class="subtotal-cell">{{ number_format((float) $producto->precio * $producto->stock, 2) }} Bs</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No hay productos registrados para el reporte.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="report-footer">
            Documento generado automaticamente desde el panel administrativo de productos.
        </div>
    </div>
</body>
</html>
