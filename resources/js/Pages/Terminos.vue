<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
</script>

<template>
    <LandingLayout>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="">
                        <h2 class="text-center text-white fw-bold mb-5 text-uppercase">
                            Términos y Condiciones Generales de la Promoción "MEGA PROMO CON GELATONI"
                        </h2>

                        <div class="terminos-content text-white">
                            <p class="mb-4">
                                Los presentes son los Términos y Condiciones bajo los cuales se desarrollará y realizará
                                por parte de INDUSTRIAS
                                LÁCTEAS TONI S.A, la promoción MEGA PROMO CON GELATONI. La persona que desee participar
                                (en adelante
                                EL CLIENTE) reconoce y acepta que el desarrollo y realización de esta actividad se
                                sujetará única y exclusivamente
                                a los mismos al tenor de las siguientes cláusulas:
                            </p>

                            <h3 class="text-white">PRIMERA: DEL ORGANIZADOR.</h3>
                            <p class="mb-4">
                                EL organizador de la presente promoción MEGA PROMO CON GELATONI, es la compañía
                                INDUSTRIAS LÁCTEAS
                                TONI S.A (en adelante EL ORGANIZADOR), con domicilio registrado en Guayaquil, Ecuador,
                                Km. 14.5 Coop.
                                San Nicolás Fte. Pascuales Mz. 429 Solar 1.
                            </p>

                            <h3 class="text-white">SEGUNDA: OBJETIVO.</h3>
                            <p class="mb-4">
                                INDUSTRIAS LÁCTEAS TONI S.A., en adelante “El Organizador”, quiere premiar a los
                                consumidores (“Los Participantes”)
                                más fieles a nivel nacional en su producto Gelatoni, registrando el código único en el
                                empaque en el landing
                                page y participar para ganar increíbles premios.
                            </p>

                            <h3 class="text-white">TERCERA: DURACIÓN Y VIGENCIA DE LA PROMOCIÓN.</h3>
                            <p class="mb-4">
                                La promoción MEGA PROMO CON GELATONI, tendrá una vigencia comprendida a partir del 15 de
                                agosto de 2021 y, finalizará el 30 de septiembre de 2021.
                                EL ORGANIZADOR se reserva el derecho a cambiar las fechas de comienzo y final de la
                                presente promoción MEGA PROMO CON GELATONI; premios, condiciones, plazos, entre otros.
                                Así mismo modificar
                                estos términos y condiciones en caso de circunstancia de fuerza mayor, fuera del control
                                o ajenas a su
                                voluntad.
                            </p>

                            <h3 class="text-white">CUARTA: OBJETO Y ÁMBITO DE APLICACIÓN.</h3>
                            <p class="mb-4">
                                Los presentes términos y condiciones generales tienen como objeto la regulación de la
                                forma de participar en la promoción
                                MEGA PROMO CON GELATONI. En caso de contradicción entre estos y otros términos y
                                condiciones, prevalecerán
                                los particulares de la promoción a que se refieren sobre los generales. El ámbito de
                                aplicación de los presentes
                                términos y condiciones de la promoción MEGA PROMO CON GELATONI corresponderá a las
                                sucursales
                                que INDUSTRIAS LÁCTEAS TONI S.A, determine y seleccione previamente.
                            </p>

                            <h3 class="text-white">QUINTA: ACEPTACIÓN DE LOS TÉRMINOS Y CONDICIONES DE USO.</h3>
                            <p class="mb-4">
                                EL CLIENTE que se adhiera a participar de la promoción GANA DIVERSIÓN CON GELATONI
                                manifiesta conocer
                                su regulación y ámbito de aplicación, manifestando a su vez, su aceptación expresa de
                                los presentes Términos y
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
.terminos-container {
    background-color: var(--toni-celeste);
    border-radius: 20px;
    min-height: 600px;
}

.terminos-content {
    font-size: 1rem;
    line-height: 1.6;
    max-height: 70vh;
    /* Para que no sea una página infinita */
    overflow-y: auto;
    /* Scroll interno si el texto es muy largo */
    padding-right: 15px;
}

/* Personalizar el scrollbar para que se vea bien */
.terminos-content::-webkit-scrollbar {
    width: 8px;
}

.terminos-content::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.terminos-content::-webkit-scrollbar-thumb {
    background: var(--toni-amarillo);
    border-radius: 10px;
}

.text-yellow {
    color: var(--toni-amarillo) !important;
}
</style>