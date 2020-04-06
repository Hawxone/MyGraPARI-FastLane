<?php

namespace App\Exports;

use App\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function headings(): array
    {
        return [
            'Nama',
            'MSISDN 1',
            'MSISDN 2',
            'MSISDN 3',
            'Group',
            'Issued',
            'Dipanggil',
            'Selesai',
            'Navigator',
            'Ambassador'
        ];
    }

    public function __construct($first, $last)
    {
            $this->first = $first;
            $this->last = $last;
    }

    public function query()
    {
        if($this->first == $this->last){
            $reporthehe = Log::query()
                ->select('nama','msisdn_1','msisdn_2','msisdn_3','keluhan','issued','dipanggil','selesai','navigator','ambassador')
                ->where('selesai','!=','00:00:00')
                ->whereDate('created_at',$this->last);
        }else{

            $reporthehe = Log::query()
                ->select('nama','msisdn_1','msisdn_2','msisdn_3','keluhan','issued','dipanggil','selesai','navigator','ambassador')
                ->where('selesai','!=','00:00:00')
                ->where('created_at','>=',$this->first,'and','created_at','<=',$this->last);

        }



        return $reporthehe;
    }
}
