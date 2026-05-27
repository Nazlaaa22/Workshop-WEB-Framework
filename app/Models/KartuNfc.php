<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuNfc extends Model
{
    protected $fillable = [
        'nama',
        'serial_number'
    ];
}
