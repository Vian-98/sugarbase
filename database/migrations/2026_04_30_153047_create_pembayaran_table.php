<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * [DEPRECATED] This migration was creating duplicate 'pembayarans' table
     * The system uses 'pembayaran' table from the main migration instead.
     * This migration is now a no-op to maintain history.
     */
    public function up(): void
    {
        // No-op: deprecated duplicate table creation
    }

    public function down(): void
    {
        // No-op: deprecated duplicate table creation
    }
};