<template>
    <LandingLayout>
        <div class="container py-5">
            <div class="row align-items-center min-vh-75">

                <div class="col-lg-6 mb-5 mb-lg-0 d-flex justify-content-center">
                    <Ranking :ranking="ranking" />
                </div>

                <div class="col-lg-6 text-center text-lg-start ps-lg-5">
                    <div class="cta-container">
                        <img src="/img/personaje-hincha.png" alt="Hincha" class="img-fluid mb-3" width="300">
                        <h1 class="display-4 fw-bold text-white text-uppercase main-title">
                            ¡Se lleva en la lonchera!
                        </h1>
                        <img src="/img/pack-productos.png" alt="Productos Toni" class="img-fluid my-4">

                        <div class="text-center">
                            <Link :href="route('dashboard')" class="btn-cta-toni shadow-lg">
                                INGRESA TU CÓDIGO AQUÍ
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
import Ranking from '@/Components/Ranking.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    ranking: Array
});
</script>

<style scoped>
.main-title {
    font-family: 'Bebas Neue', sans-serif;
    color: var(--toni-amarillo);
    text-shadow: 2px 2px 0px var(--toni-azul-marino);
}

.btn-cta-toni {
    display: inline-block;
    background-color: var(--toni-amarillo);
    color: var(--toni-azul-marino);
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2rem;
    padding: 15px 40px;
    border-radius: 50px 15px 50px 15px;
    /* Estilo irregular de la imagen */
    text-decoration: none;
    font-weight: bold;
    transition: transform 0.2s, background-color 0.2s;
    border: 3px solid var(--toni-azul-marino);
}

.btn-cta-toni:hover {
    transform: scale(1.05) rotate(-1deg);
    background-color: #ffd700;
    color: var(--toni-azul-marino);
}

.min-vh-75 {
    min-height: 75vh;
}
</style>