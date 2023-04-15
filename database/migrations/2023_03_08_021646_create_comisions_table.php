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
        // Si no existe tabla crearla, caso contrario editarla
        if (!Schema::hasTable('comisions')) {
            Schema::create('comisions', function (Blueprint $table) {
                $table->id("id_comision");
                $table->string("nombre_comision");
                $table->integer("estado_comision")->default(1);
            });
        } else {
            Schema::table('comisions', function (Blueprint $table) {
                $table->string('imagen', 50)->after('nombre_comision')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comisions');
    }
};
