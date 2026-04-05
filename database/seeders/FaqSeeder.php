<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'pregunta' => '¿En qué consiste la promoción?',
                'respuesta' => 'Es una promoción organizada por Industrias Lácteas Toni S.A. que premia a sus consumidores por la compra de productos participantes, permitiéndoles acumular puntos y participar para ganar premios semanales y paquetes futboleros para asistir a un partido de la selección de Ecuador.',
            ],
            [
                'pregunta' => '¿Quiénes pueden participar?',
                'respuesta' => 'Pueden participar personas ecuatorianas mayores de 18 años y extranjeros residentes en Ecuador.',
            ],
            [
                'pregunta' => '¿Cómo puedo participar?',
                'respuesta' => 'Debes registrarte en www.contonisiempreganas.com, aceptar los términos y condiciones, escanear el código QR de la promoción e ingresar el código único del empaque del producto participante.',
            ],
            [
                'pregunta' => '¿Qué productos participan y cuántos puntos otorgan?',
                'respuesta' => 'Participa el portafolio de productos Toni incluidos en la promoción. Los productos tamaño personal otorgan 50 puntos y los tamaños familiares otorgan 100 puntos.',
            ],
            [
                'pregunta' => '¿Cómo se eligen a los ganadores de los premios principales?',
                'respuesta' => 'Los ganadores se determinan por un ranking de puntos acumulados durante el período de vigencia. En caso de empate, gana quien haya alcanzado el puntaje primero.',
            ],
            [
                'pregunta' => '¿Cuánto tiempo dura la promoción?',
                'respuesta' => 'La promoción estará vigente del 6 de abril al 28 de junio de 2026 o hasta agotar stock. Los ganadores de los premios principales se anunciarán el 2 de junio de 2026. El sorteo de premios semanales continúa hasta el 28 de junio de 2026.',
            ],
            [
                'pregunta' => '¿Qué pasa si no tengo visa para viajar?',
                'respuesta' => 'Los ganadores del primer y segundo premio deben gestionar sus trámites migratorios para ingresar al país de destino. El organizador no se responsabiliza por permisos o gestiones migratorias ni de visas. Aplican términos y condiciones.',
            ],
            [
                'pregunta' => '¿Dónde se anunciarán los ganadores?',
                'respuesta' => 'Los ganadores se anunciarán en redes oficiales de Toni en Instagram (@tonilacteos y @pasiondelhinchatoni) y en www.contonisiempreganas.com, además de ser contactados por correo o teléfono.',
            ],
        ];

        foreach ($faqs as $orden => $faq) {
            Faq::firstOrCreate(
                ['pregunta' => $faq['pregunta']],
                [
                    'respuesta' => $faq['respuesta'],
                    'orden'     => $orden + 1,
                ]
            );
        }
    }
}
