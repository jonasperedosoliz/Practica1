<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class BaseStyledReportExport implements FromArray, ShouldAutoSize, WithColumnWidths, WithEvents
{
    use Exportable;

    protected Collection $records;

    protected Carbon $generatedAt;

    protected int $tableHeaderRow = 8;

    public function __construct(Collection $records)
    {
        $this->records = $records->values();
        $this->generatedAt = Carbon::now();
    }

    public function array(): array
    {
        $blankRow = array_fill(0, count($this->headings()), '');

        $rows = [
            [$this->reportTitle()],
            [$this->reportSubtitle()],
            ['Fecha de generacion: '.$this->generatedAt->format('d/m/Y H:i')],
            $blankRow,
            $blankRow,
            $blankRow,
            $blankRow,
            $this->headings(),
        ];

        foreach ($this->records as $index => $record) {
            $rows[] = $this->mapRecord($record, $index);
        }

        return $rows;
    }

    public function columnWidths(): array
    {
        return $this->sheetColumnWidths();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = Coordinate::stringFromColumnIndex(count($this->headings()));
                $firstDataRow = $this->tableHeaderRow + 1;
                $lastDataRow = $firstDataRow + max($this->records->count() - 1, 0);

                $sheet->setShowGridLines(false);
                $sheet->freezePane('A'.$firstDataRow);
                $sheet->mergeCells('A1:'.$lastColumn.'1');
                $sheet->mergeCells('A2:'.$lastColumn.'2');
                $sheet->mergeCells('A3:'.$lastColumn.'3');

                $sheet->getStyle('A1:'.$lastColumn.'1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 20,
                        'color' => ['rgb' => '132238'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A2:'.$lastColumn.'2')->applyFromArray([
                    'font' => [
                        'size' => 11,
                        'color' => ['rgb' => '5F7086'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A3:'.$lastColumn.'3')->applyFromArray([
                    'font' => [
                        'size' => 10,
                        'bold' => true,
                        'color' => ['rgb' => '6B7F95'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'C9D7E6'],
                        ],
                    ],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension($this->tableHeaderRow)->setRowHeight(24);

                foreach ($this->summaryCards() as $index => $card) {
                    $startIndex = ($index * 2) + 1;

                    if ($startIndex > count($this->headings())) {
                        break;
                    }

                    $endIndex = min($startIndex + 1, count($this->headings()));
                    $startColumn = Coordinate::stringFromColumnIndex($startIndex);
                    $endColumn = Coordinate::stringFromColumnIndex($endIndex);
                    $labelRange = $startColumn.'5:'.$endColumn.'5';
                    $valueRange = $startColumn.'6:'.$endColumn.'6';
                    $fillColor = $card['fill'] ?? 'EEF4FF';
                    $accentColor = $card['accent'] ?? '3B82F6';

                    $sheet->mergeCells($labelRange);
                    $sheet->mergeCells($valueRange);
                    $sheet->setCellValue($startColumn.'5', $card['label']);
                    $sheet->setCellValue($startColumn.'6', $card['value']);

                    $sheet->getStyle($labelRange)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 10,
                            'color' => ['rgb' => $accentColor],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => $fillColor],
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => Border::BORDER_THICK,
                                'color' => ['rgb' => $accentColor],
                            ],
                            'left' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'C9D7E6'],
                            ],
                            'right' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'C9D7E6'],
                            ],
                        ],
                    ]);

                    $sheet->getStyle($valueRange)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 16,
                            'color' => ['rgb' => '132238'],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => $fillColor],
                        ],
                        'borders' => [
                            'bottom' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'C9D7E6'],
                            ],
                            'left' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'C9D7E6'],
                            ],
                            'right' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'C9D7E6'],
                            ],
                        ],
                    ]);
                }

                $sheet->getStyle('A'.$this->tableHeaderRow.':'.$lastColumn.$this->tableHeaderRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => '173E6C'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'D5E0EB'],
                        ],
                    ],
                ]);

                if ($this->records->isNotEmpty()) {
                    $dataRange = 'A'.$firstDataRow.':'.$lastColumn.$lastDataRow;

                    $sheet->getStyle($dataRange)->applyFromArray([
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'E1E8F0'],
                            ],
                        ],
                    ]);

                    for ($row = $firstDataRow; $row <= $lastDataRow; $row++) {
                        if (($row - $firstDataRow) % 2 === 1) {
                            $sheet->getStyle('A'.$row.':'.$lastColumn.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FBFF');
                        }
                    }
                }

                $this->afterSheet($sheet, $firstDataRow, $lastDataRow);
            },
        ];
    }

    protected function afterSheet(Worksheet $sheet, int $firstDataRow, int $lastDataRow): void
    {
        // Cada reporte aplica aqui sus detalles finales de formato.
    }

    abstract protected function reportTitle(): string;

    abstract protected function reportSubtitle(): string;

    abstract protected function headings(): array;

    abstract protected function mapRecord(mixed $record, int $index): array;

    abstract protected function summaryCards(): array;

    abstract protected function sheetColumnWidths(): array;
}
