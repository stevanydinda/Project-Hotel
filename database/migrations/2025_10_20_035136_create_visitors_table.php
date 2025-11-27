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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('id_visitors')->unique();
            $table->string('nama_tamu');
            $table->string('jenis_kelamin');
            $table->string('no_telepon');
            $table->string('email');
            $table->text('alamat');
            $table->string('no_identitas');
            $table->string('tipe_identitas'); 
            $table->string('id_pemesanan');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint ke tabel bookings
            $table->foreign('id_pemesanan')->references('p_lu_Pemesanan')->on('bookings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
