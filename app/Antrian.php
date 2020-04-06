<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_antrian','nama', 'no_ktp', 'msisdn_1', 'msisdn_2','msisdn_3','navigator','dipanggil','selesai', 'ambassador','keluhan','issued'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
