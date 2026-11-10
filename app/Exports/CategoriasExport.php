<?php

namespace App\Exports;

use App\Models\Categoria;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoriasExport extends BaseStyledReportExport
{
    public function __construct(Collection $categorias)
    {
        parent::__construct($categorias);
    }

    public static function makeFromDatabase(): self
    {
        return new self(
            Categoria::withCount('productos')
                ->orderBy('id')
                ->get()
        );
    }

    protected function reportTitle(): string
    {
        return 'REPORTE DE CATEGORIAS';
    }

    protected function reportSubtitle(): string
    {
        return 'Resumen administrativo del catalogo con estado operativo y relacion de productos.';
    }

    protected function headings(): array
    {
        return ['Numero', 'Codigo', 'Nombre', 'Descripcion', 'Estado', 'Productos vinculados'];
    }

    protected function mapRecord(mixed $record, int $index): array
    {
        return [
            $index + 1,
            'CAT-'.str_pad((string) $record->id, 4, '0', STR_PAD_LEFT),
            $record->nombre,
            $record->descripcion ?: 'Sin descripcion registrada',
            $record->estado ? 'Activa' : 'Inactiva',
            (int) ($record->productos_count ?? 0),
        ];
    }

    protected function summaryCards(): array
    {
        return [
            [
                'label' => 'TOTAL CATEGORIAS',
                'value' => $this->records->count(),
                'fill' => 'EEF4FF',
                'accent' => '3B82F6',
            ],
            [
                'label' => 'CATEGORIAS ACTIVAS',
                'value' => $this->records->where('estado', true)->count(),
                'fill' => 'ECFDF3',
                'accent' => '16A34A',
            ],
            [
                'label' => 'CATEGORIAS INACTIVAS',
                'value' => $this->records->where('estado', false)->count(),
                'fill' => 'FFF4E8',
                'accent' => 'F59E0B',
            ],
        ];
    }

    protected function sheetColumnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 18,
            'C' => 28,
            'D' => 55,
            'E' => 16,
            'F' => 22,
        ];
    }

    protected function afterSheet(Worksheet $sheet, int $firstDataRow, int $lastDataRow): void
    {
        if ($this->records->isEmpty()) {
            return;
        }

        $sheet->getStyle('A'.$firstDataRow.':B'.$lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E'.$firstDataRow.':F'.$lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        for ($row = $firstDataRow; $row <= $lastDataRow; $row++) {
            $estado = (string) $sheet->getCell('E'.$row)->getValue();
            $color = $estado === 'Activa' ? 'E8F8EE' : 'FFF3E8';
            $font = $estado === 'Activa' ? '167345' : 'B86A13';

            $sheet->getStyle('E'.$row)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => $font],
                ],
            ]);

            $sheet->getStyle('E'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
        }
    }
}
