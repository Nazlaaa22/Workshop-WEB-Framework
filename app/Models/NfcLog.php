<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NfcLog extends Model
{
    protected $fillable = [
    'nama',
    'serial_number',
    'scan_time'
    ];
}
