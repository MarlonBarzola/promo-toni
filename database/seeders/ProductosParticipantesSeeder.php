<?php

namespace Database\Seeders;

use App\Models\ProductoParticipante;
use Illuminate\Database\Seeder;

class ProductosParticipantesSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            'LECHE TONI',
            'AVENA TONI',
            'LECHES SABORIZADAS',
            'YOGURT TONI',
            'YOGURT GRIEGO',
            'YOGURT KÉFIR',
            'TONIMIX',
            'CAFFE LATO',
            'QUESO CREMA TONI',
            'MANJAR TONI',
        ];

        foreach ($productos as $orden => $nombre) {
            ProductoParticipante::firstOrCreate(
                ['nombre' => $nombre],
                ['orden' => $orden + 1, 'activo' => true]
            );
        }
    }
}
