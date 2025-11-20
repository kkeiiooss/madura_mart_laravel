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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_pemesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status_pemesanan', ['draft', 'dipesan', 'diproses', 'dikirim', 'sampai tujuan', 'diterima', 'selesai', 'dibatalkan pembeli', 'dibatalkan penjual']);
            $table->enum('metode_pembayaran', ['tf', 'cod']);
            $table->integer('total_bayar')->default(0);
            $table->text('keterangan_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
