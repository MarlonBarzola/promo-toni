<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Índice compuesto para SUM(lotes.puntos) WHERE user_id = ? AND estado = 'aprobado'
        // Usado en: AdminController::update(), CodigoController::index()
        Schema::table('codigos', function (Blueprint $table) {
            $table->index(['user_id', 'estado'], 'codigos_user_estado_idx');
        });

        // Índice para ORDER BY puntos_acumulados DESC en el ranking público
        // Usado en: HomeController::index()
        Schema::table('users', function (Blueprint $table) {
            $table->index('puntos_acumulados', 'users_puntos_idx');
        });
    }

    public function down(): void
    {
        Schema::table('codigos', function (Blueprint $table) {
            $table->dropIndex('codigos_user_estado_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_puntos_idx');
        });
    }
};
