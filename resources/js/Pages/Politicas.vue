<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    contenido: String,
});
</script>

<template>

    <Head title="Política de Privacidad" />
    <LandingLayout>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terminos-content text-white">
                        <h2 class="text-white text-center text-uppercase mb-2">Política de Privacidad - Promoción "Alimentando la Pasión del Hincha"</h2>

                        <p class="mb-2">
                            En cumplimiento de lo dispuesto en la Ley Orgánica de Protección de Datos Personales, Toni
                            informa a los usuarios que los datos personales proporcionados a través de este sitio web
                            serán tratados de manera lícita, leal y transparente, garantizando en todo momento su
                            confidencialidad y seguridad.
                        </p>
                        <p  class="mb-2">
                            Los datos personales recabados serán utilizados exclusivamente para la gestión, desarrollo y
                            ejecución de la promoción “Alimentando la Pasión del Hincha”, incluyendo la validación de la
                            participación, la realización de sorteos, la notificación a los ganadores y la entrega de
                            premios semanales y del premio final.
                        </p>

                        <p  class="mb-2">
                            La base legal para el tratamiento de los datos personales es el consentimiento libre,
                            específico, informado e inequívoco del titular, otorgado mediante la aceptación expresa al
                            momento de completar el formulario de participación. La entrega de los datos solicitados es
                            voluntaria; sin embargo, su falta impedirá la participación en la promoción.
                        </p>

                        <p  class="mb-2">
                            Toni no compartirá, cederá ni transferirá los datos personales a terceros, salvo en los
                            casos previstos por la ley o cuando sea necesario para el cumplimiento de obligaciones
                            legales o la correcta ejecución de la promoción.
                        </p>

                        <p  class="mb-2">
                            El titular de los datos podrá ejercer sus derechos de acceso, rectificación, actualización,
                            eliminación, oposición y portabilidad, conforme a lo establecido en la ley, mediante
                            solicitud dirigida a los canales oficiales de contacto de Toni.
                        </p>

                        <p  class="mb-2">
                            Toni implementa las medidas de seguridad técnicas y organizativas necesarias para proteger
                            los datos personales contra pérdida, acceso no autorizado, alteración o divulgación.
                        </p>

                        <p  class="mb-2">
                            Al participar en la promoción, el usuario declara haber leído, entendido y aceptado la
                            presente Política de Privacidad.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
.terminos-content {
    font-size: 1rem;
    line-height: 1.6;
    padding-right: 15px;
}

:deep(.tiptap-output h1) {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

:deep(.tiptap-output h2) {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

:deep(.tiptap-output h3) {
    font-weight: bold;
    margin-bottom: 0.4rem;
}

:deep(.tiptap-output p) {
    margin-bottom: 0.8rem;
}

:deep(.tiptap-output ul) {
    padding-left: 1.5rem;
    margin-bottom: 0.8rem;
    list-style: disc;
}

:deep(.tiptap-output ol) {
    padding-left: 1.5rem;
    margin-bottom: 0.8rem;
    list-style: decimal;
}

:deep(.tiptap-output li) {
    display: list-item;
}
</style>
