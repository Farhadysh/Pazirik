<?php
/**
 * Created by PhpStorm.
 * User: Farhad
 * Date: 12/11/2019
 * Time: 2:26 PM
 */
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromArray, WithEvents
{


    public function __construct(array $orderExcel)
    {
        $this->orderExcel = $orderExcel;
    }
    /**
     * @return array
     */
    public function array(): array
    {
        return $this->orderExcel;
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