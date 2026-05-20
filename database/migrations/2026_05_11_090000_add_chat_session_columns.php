<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom untuk fitur Live Chat & Booking:
     * - chat.konsultasi_id → menghubungkan pesan ke sesi konsultasi
     * - konsultasi.chat_status → menentukan siapa responder (bot/nakes)
     * - konsultasi.status → update enum agar mendukung status tambahan
     */
    public function up(): void
    {
        // 1. Tambah konsultasi_id ke tabel chat
        Schema::table('chat', function (Blueprint $table) {
            $table->foreignId('konsultasi_id')
                ->nullable()
                ->after('nakes_id')
                ->constrained('konsultasi')
                ->nullOnDelete();
        });

        // 2. Tambah chat_status ke tabel konsultasi
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->enum('chat_status', ['bot', 'nakes'])->default('bot')->after('status');
        });

        // 3. Update enum status konsultasi agar mendukung lebih banyak status
        // Menggunakan raw SQL karena Laravel tidak bisa alter enum secara langsung
        DB::statement("ALTER TABLE konsultasi MODIFY COLUMN status ENUM('pending','dijadwalkan','diterima','ditolak','selesai','batal') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat', function (Blueprint $table) {
            $table->dropForeign(['konsultasi_id']);
            $table->dropColumn('konsultasi_id');
        });

        Schema::table('konsultasi', function (Blueprint $table) {
            $table->dropColumn('chat_status');
        });

        DB::statement("ALTER TABLE konsultasi MODIFY COLUMN status ENUM('dijadwalkan','selesai','batal') DEFAULT 'dijadwalkan'");
    }
};
