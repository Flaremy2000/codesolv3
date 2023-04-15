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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('mv', 8)->unique();
            $table->string('cedula', 10)->unique();
            $table->string('name');
            $table->string('lastname');
            $table->string('phone', 10)->unique();
            $table->string('emergency_phone', 10)->unique();
            $table->string('email', 100)->unique();
            $table->date('birthdate');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->integer('is_online')->default(0);
            $table->integer('is_socio')->default(0);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
