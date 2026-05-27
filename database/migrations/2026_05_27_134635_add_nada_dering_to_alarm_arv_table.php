<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('alarm_arv', function (Blueprint $table) {
        $table->string('nada_dering')->nullable()->default('Default');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alarm_arv', function (Blueprint $table) {
            //
        });
    }
};
