<?php
/**
 * Created by PhpStorm.
 * User: Farhad
 * Date: 6/16/2019
 * Time: 4:41 PM
 */

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    use Exportable;


    public function query()
    {
        return User::query()->select('name','last_name','mobile','phone')->where('level','user');
    }

    public function headings(): array
    {
        return [
            'نام',
            'نام خانوادگی',
            'شماره موبایل',
            'تلفن ثابت',
        ];
    }
}