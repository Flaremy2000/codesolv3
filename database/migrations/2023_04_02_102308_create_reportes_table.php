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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id('id_reporte');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_incidente');
            $table->text('descripcion');
            $table->dateTime('fecha_reporte');
            $table->text('comentarios')->nullable();
            $table->dateTime('fecha_comentario')->nullable();
            $table->integer('estado')->default(1);
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_incidente')->references('id_categoria')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};