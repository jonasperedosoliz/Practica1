<?php

namespace App\Exports;

use App\Models\Producto;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductosExport extends BaseStyledReportExport
{
    public function __construct(Collection $productos)
    {
        parent::__construct($productos);
    }

    public static function makeFromDatabase(): self
    {
        return new self(
            Producto::with('categoria')
                ->orderBy('id')
                ->get()
        );
    }

    protected function reportTitle(): string
    {
        return 'REPORTE DE PRODUCTOS';
    }

    protected function reportSubtitle(): string
    {
        return 'Inventario consolidado con categoria, precio, stock actual y valor estimado.';
    }

    protected function headings(): array
    {
        return ['Numero', 'Codigo', 'Producto', 'Descripcion', 'Categoria', 'Precio (Bs)', 'Stock', 'Valor inventario'];
    }

    protected function mapRecord(mixed $record, int $index): array
    {
        return [
            $index + 1,
            'PROD-'.str_pad((string) $record->id, 4, '0', STR_PAD_LEFT),
            $record->nombre,
            $record->descripcion ?: 'Sin descripcion registrada',
            $record->categoria->nombre ?? 'Sin categoria',
            (float) $record->precio,
            (int) $record->stock,
            (float) $record->precio * (int) $record->stock,
        ];
    }

    protected function summaryCards(): array
    {
        return [
            [
                'label' => 'TOTAL PRODUCTOS',
                'value' => $this->records->count(),
                'fill' => 'EEF4FF',
                'accent' => '3B82F6',
            ],
            [
                'label' => 'CATEGORIAS CUBIERTAS',
                'value' => $this->records->pluck('categoria_id')->filter()->unique()->count(),
                'fill' => 'ECFDF3',
                'accent' => '16A34A',
            ],
            [
                'label' => 'STOCK ACUMULADO',
                'value' => $this->records->sum('stock'),
                'fill' => 'EFFAFD',
                'accent' => '0EA5B7',
            ],
            [
                'label' => 'VALOR TOTAL INVENTARIO',
                'value' => number_format($this->records->sum(fn ($producto) => (float) $producto->precio * (int) $producto->stock), 2).' Bs',
                'fill' => 'FFF7ED',
                'accent' => 'EA580C',
            ],
        ];
    }

    protected function sheetColumnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 18,
            'C' => 32,
            'D' => 58,
            'E' => 24,
            'F' => 16,
            'G' => 12,
            'H' => 18,
        ];
    }

    protected function afterSheet(Worksheet $sheet, int $firstDataRow, int $lastDataRow): void
    {
        if ($this->records->isEmpty()) {
            return;
        }

        $sheet->getStyle('A'.$firstDataRow.':B'.$lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F'.$firstDataRow.':H'.$lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F'.$firstDataRow.':F'.$lastDataRow)->getNumberFormat()->setFormatCode('#,##0.00 "Bs"');
        $sheet->getStyle('G'.$firstDataRow.':G'.$lastDataRow)->getNumberFormat()->setFormatCode('0');
        $sheet->getStyle('H'.$firstDataRow.':H'.$lastDataRow)->getNumberFormat()->setFormatCode('#,##0.00 "Bs"');

        for ($row = $firstDataRow; $row <= $lastDataRow; $row++) {
            $stock = (int) $sheet->getCell('G'.$row)->getValue();

            if ($stock <= 5) {
                $sheet->getStyle('G'.$row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'B91C1C'],
                    ],
                ]);
                $sheet->getStyle('G'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FEECEC');
            } elseif ($stock <= 15) {
                $sheet->getStyle('G'.$row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'A16207'],
                    ],
                ]);
                $sheet->getStyle('G'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF7DB');
            } else {
                $sheet->getStyle('G'.$row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '166534'],
                    ],
                ]);
                $sheet->getStyle('G'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('ECFDF3');
            }
        }
    }
}
