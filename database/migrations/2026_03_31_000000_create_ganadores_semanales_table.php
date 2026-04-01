<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ganadores_semanales', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->string('usuario')->nullable();
            $table->unsignedTinyInteger('numero_semana');
            $table->unsignedSmallInteger('anio');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ganadores_semanales');
    }
};
