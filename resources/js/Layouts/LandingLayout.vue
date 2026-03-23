<script setup>
import { ref } from 'vue';
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';

const activeModal = ref(null);

const openLogin = () => activeModal.value = 'login';
const openRegister = () => activeModal.value = 'register';
const closeModal = () => activeModal.value = null;
</script>

<template>
    <div class="landing-background">
        <Navbar 
            @open-login="openLogin" 
            @open-register="openRegister"
        />

        <slot 
            :activeModal="activeModal"
            :closeModal="closeModal"
            :openLogin="openLogin"
            :openRegister="openRegister"
        />

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