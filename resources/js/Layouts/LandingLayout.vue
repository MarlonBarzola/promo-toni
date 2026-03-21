<template>
    <div class="landing-background">
        <Navbar />

        <slot />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
</script>

<style>
.landing-background {
    background-color: var(--toni-azul-marino);
    /* Aquí conectarás la imagen del estadio azul de fondo */
    background-image: linear-gradient(rgba(0, 51, 160, 0.7), rgba(0, 51, 160, 0.7)), url('/img/fondo-estadio.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 100vh;
    width: 100%;
    overflow-x: hidden;
}
</style>