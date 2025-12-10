<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('p_lu_Pemesanan')->unique();  // Perbaiki typo disini
            $table->string('id_User');
            $table->integer('id_Kamar');
            $table->date('tgl_checkin');
            $table->date('tgl_checkout');
            $table->integer('jnu_kamar_dipesan');
            $table->string('status_pemesanan');
            $table->timestamps();  // tanpa (s)
            $table->softDeletes(); // tanpa (s)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
