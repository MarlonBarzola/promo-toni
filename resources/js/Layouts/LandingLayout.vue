<script setup>
import { ref, defineAsyncComponent } from 'vue';
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
import AuthModal from '@/Components/Common/AuthModal.vue';

const RegistrationForm = defineAsyncComponent(() =>
    import('@/Components/Landing/RegistrationForm.vue')
);
const LoginForm = defineAsyncComponent(() =>
    import('@/Components/Landing/LoginForm.vue')
);

const activeModal = ref(null);

const openLogin = () => activeModal.value = 'login';
const openRegister = () => activeModal.value = 'register';
const closeModal = () => activeModal.value = null;
</script>

<template>
    <div class="landing-background">
        <Navbar @open-login="openLogin" @open-register="openRegister" />

        <slot :activeModal="activeModal" :closeModal="closeModal" :openLogin="openLogin" :openRegister="openRegister" />

        <AuthModal :show="activeModal !== null" @close="closeModal">

            <div v-if="activeModal === 'register'">
                <RegistrationForm @success="closeModal" @go-login="openLogin" />
            </div>

            <div v-if="activeModal === 'login'">
                <LoginForm @success="closeModal" @go-register="openRegister" />
            </div>

        </AuthModal>

        <Footer />
    </div>
</template>

<style>
.landing-background {
    background-color: var(--toni-azul-marino);
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 100vh;
    width: 100%;
    overflow-x: hidden;
}
</style>