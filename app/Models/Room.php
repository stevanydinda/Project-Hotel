<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
     protected $fillable = [
        'tipe_kamar',
        'harga',
        'jumlah_kamar',
        'hotel_id',
        'kapasitas',
        'deskripsi',
        'image',

    ];

}
