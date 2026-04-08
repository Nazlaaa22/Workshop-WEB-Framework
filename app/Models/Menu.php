<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'idmenu';

    public $timestamps = false;

    protected $fillable = [
        'nama_menu',
        'harga',
        'path_gambar',
        'user_id'
    ];
}