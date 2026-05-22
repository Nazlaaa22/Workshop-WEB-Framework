<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = [
        'kode_antrian',
        'nama_pasien',
        'poli',
        'loket',
        'status',
        'waktu_panggil'
    ];
}