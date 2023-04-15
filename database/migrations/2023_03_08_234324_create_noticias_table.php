<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id("id_noticia");
            $table->string("titulo");
            $table->text("texto_largo")->nullable();
            $table->string("imagen")->nullable();
            $table->string("archivo")->nullable();
            $table->date("fecha");
            $table->unsignedBigInteger("categoria_id");
            $table->foreign("categoria_id")->references("id_categoria")->on("categorias")->onDelete("cascade");
            $table->integer("estado")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
