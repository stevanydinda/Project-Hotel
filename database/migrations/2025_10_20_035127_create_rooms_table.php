<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->string('tipe_kamar');               // contoh: Deluxe, Superior, Suite
            $table->decimal('harga', 12, 2);             // harga per malam
            $table->integer('jumlah_kamar')->default(0); // stok kamar tersedia

            // Tidak jadi relasi ke hotels → tetap boleh ada ID untuk fleksibilitas

            // tidak ada table hotel jadi tidak bisa ada relasi apapun untuk hotel_id, kampung
            // $table->unsignedBigInteger('hotel_id')->nullable();

            $table->integer('kapasitas')->default(1);     // jumlah orang
            $table->text('deskripsi')->nullable();        // detail kamar
            $table->string('image')->nullable();          // foto kamar (path file)

            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
