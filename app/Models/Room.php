<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

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
