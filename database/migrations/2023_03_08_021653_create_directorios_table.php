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
        Schema::create('directorios', function (Blueprint $table) {
            $table->id("id_directorio");
            $table->string("nombre_directorio");
            $table->string("apellido_directorio");
            $table->string("imagen_directorio");
            $table->unsignedBigInteger("cargo_directorio");
            $table->unsignedBigInteger("comision_directorio");
            $table->unsignedBigInteger("periodo_directorio");
            $table->foreign("cargo_directorio")->references("id_cargo")->on("cargos");
            $table->foreign("comision_directorio")->references("id_comision")->on("comisions");
            $table->foreign("periodo_directorio")->references("id_periodo")->on("periodos");
            $table->integer("estado_directorio")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directorios');
    }
};
