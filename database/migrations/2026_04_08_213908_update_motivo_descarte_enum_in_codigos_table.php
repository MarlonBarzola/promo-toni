<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE codigos MODIFY COLUMN motivo_descarte ENUM('codigo_empaque', 'foto', 'mejor_foto', 'caducado') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE codigos MODIFY COLUMN motivo_descarte ENUM('codigo_empaque', 'foto') NULL");
    }
};
