<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alarm_arv', function (Blueprint $table) {
            // Tambahkan kolom nada_dering
            $table->string('nada_dering')->nullable()->after('waktu');
        });
    }

    public function down(): void
    {
        Schema::table('alarm_arv', function (Blueprint $table) {
            $table->dropColumn('nada_dering');
        });
    }
};