<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom 'role' ke tabel users.
     *
     * Kolom ini wajib ada karena tabel users bawaan Laravel
     * menggantikan tabel AKUN, ADMIN, dan PELANGGAN yang
     * sebelumnya terpisah dalam desain database awal.
     *
     * Jalankan setelah migration users bawaan Laravel:
     *   php artisan migrate
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pelanggan'])
                  ->default('pelanggan')
                  ->after('name')
                  ->comment('Role pengguna: admin atau pelanggan');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};