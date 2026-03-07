<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsu extends Model
{
    protected $fillable = [
        'rsu_uid',
        'latitude',
        'longitude',
        'tx_power',
    ];
}
