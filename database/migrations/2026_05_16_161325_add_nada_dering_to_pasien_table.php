<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            // Menambahkan kolom nada dering dengan default 'Standard Beep'
            $table->string('nada_dering')->default('Standard Beep')->after('status_kepatuhan');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('nada_dering');
        });
    }
};