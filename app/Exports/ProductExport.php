<?php
/**
 * Created by PhpStorm.
 * User: Farhad
 * Date: 12/12/2019
 * Time: 11:51 AM
 */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromArray, WithEvents
{

    public function __construct(array $productExcel)
    {
        $this->productExcel = $productExcel;
    }
    /**
     * @return array
     */
    public function array(): array
    {
        return $this->productExcel;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            }
        ];
    }
}