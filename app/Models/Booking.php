<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'p_lu_Pemesanan',
        'id_User',
        'id_Kamar',
        'tgl_checkin',
        'tgl_checkout',
        'jnu_kamar_dipesan',
        'total_harga',
        'status_pemesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_User');
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'id_Kamar', 'id');
    }

   public function payments()
  {
    return $this->hasOne(Payment::class, 'id_Pemesanan', 'p_lu_Pemesanan');
  }

}

