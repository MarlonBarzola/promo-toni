<script setup>
import Footer from '@/Components/Footer.vue';
import SectionDivider from '@/Components/SectionDivider.vue';
import Navbar from '@/Components/Navbar.vue';

defineProps({
    dividerBgTop: {
        type: String,
        default: 'var(--toni-azul-marino)'
    }
});
</script>

<template>
    <div class="landing-background">
        <Navbar />

        <slot />

        <SectionDivider :bgTop="dividerBgTop" bgBottom="var(--toni-azul-cobalto)" />

        <Footer />
    </div>
</template>
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