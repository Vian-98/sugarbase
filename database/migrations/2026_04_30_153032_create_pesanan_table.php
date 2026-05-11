<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pesanan_item');
        Schema::dropIfExists('pesanans');

        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('user_id')->constrained();
            $table->date('tanggal_pesan');
            $table->decimal('total_harga', 15, 2);
            $table->enum('status_pesanan', ['pending','diproses','dikirim','selesai','dibatalkan'])
                  ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};