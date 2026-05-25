<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * [DEPRECATED] This migration was creating 'pesanan_item' table (empty/unused)
     * The system uses 'tracking_status' table for order tracking instead.
     * This migration is now a no-op to maintain history.
     */
    public function up(): void
    {
        // No-op: deprecated unused table creation
    }

    public function down(): void
    {
        // No-op: deprecated unused table creation
    }
};