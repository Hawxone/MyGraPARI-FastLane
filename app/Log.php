<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'nomor_antrian','nama', 'no_ktp', 'msisdn_1', 'msisdn_2','msisdn_3','navigator','dipanggil','selesai','ambassador','keluhan','issued','keterangan'
    ];

}
