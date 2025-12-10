<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'kapasitas',
        'image',
        'tipe_kamar',
        'harga',
        'jumlah_kamar',
        'deskripsi',
    ];
    public function bookings()
    {
    return $this->hasMany(Booking::class, 'id_Kamar', 'id');
    }

}
