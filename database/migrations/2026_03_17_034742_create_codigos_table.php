<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('codigos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('codigo_unico')->unique();
            $table->string('producto');
            $table->string('foto_codigo');
            $table->string('foto_empaque');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente'); // [cite: 106, 108, 111]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos');
    }
};
