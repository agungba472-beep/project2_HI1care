<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faskes', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('tipe')->default('Rumah Sakit'); // Rumah Sakit, Puskesmas, Mandiri
            $table->string('layanan')->nullable();          // ARV, PDP, VL, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faskes');
    }
};
