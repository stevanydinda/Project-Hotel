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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('id_Pembayaran')->unique();
            $table->string('id_Pemesanan'); // Ini yang akan jadi foreign key
            $table->string('metode_pembayaran');
            $table->integer('jumlah_bayar');
            $table->string('status_pembayaran');
            $table->date('tanggal_bayar');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
