<script setup>
import { Head } from '@inertiajs/vue3';
import LandingLayout from '@/Layouts/LandingLayout.vue';
</script>

<template>

    <Head title="Ganadores" />
    <LandingLayout>
        <div class="bg-malla">
            <div class="container">
                <div class="malla-container">
                    <div class="img-malla">
                        <img class="d-none d-lg-block" src="/images/ganadores-semanales.png"
                            alt="Gana premios semanales" />
                        <img class="d-block d-lg-none" src="/images/ganadores-semanales-mobile.png"
                            alt="Gana premios semanales" />
                    </div>
                    <div class="malla-content">
                        <div class="content-container">
                            <img src="/images/titulo-ganadores.png" alt="Ganadores semanales"
                                class="mb-2 titulo-ganadores">
                            <!-- nuevo módulo aquí -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
.content-container {
    background-color: var(--toni-celeste);
    border-radius: 20px;
    min-height: 538px;
}

.titulo-ganadores {
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
    margin-bottom: 0px;
    transform: translateY(-55px);
}

@media (max-width: 992px) {
    .img-malla {
        margin-bottom: -2.4rem;
        position: relative;
    }
}
</style>
