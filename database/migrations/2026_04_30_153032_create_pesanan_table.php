public function up(): void
{
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