<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imagereports', function (Blueprint $table) {
            $table->id('id_imagereport');
            $table->string('imagen', 100);
            $table->unsignedBigInteger('id_reporte');
            $table->foreign('id_reporte')->references('id_reporte')->on('reportes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagereports');
    }
};