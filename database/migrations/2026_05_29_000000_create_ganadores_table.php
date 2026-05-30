<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ganadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('posicion');
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();

            $table->unique('posicion');
            $table->unique('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ganadores');
    }
};
