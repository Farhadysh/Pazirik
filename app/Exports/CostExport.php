<?php
/**
 * Created by PhpStorm.
 * User: Farhad
 * Date: 6/18/2019
 * Time: 2:49 PM
 */

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CostExport implements FromArray, WithEvents
{


    public function __construct(array $costExcel)
    {
        $this->costExcel = $costExcel;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->costExcel;
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