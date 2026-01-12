<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to ensure it works without Doctrine DBAL and handles Enum to String conversion
        DB::statement("ALTER TABLE pengaduan MODIFY COLUMN status VARCHAR(50) DEFAULT 'Menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum if needed, but string is safer for now.
        // We won't revert strict enum to avoid data loss if we have new statuses.
        // But for correctness:
        // DB::statement("ALTER TABLE pengaduan MODIFY COLUMN status ENUM('baru', 'proses', 'selesai') DEFAULT 'baru'");
    }
};
