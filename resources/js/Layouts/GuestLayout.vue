<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="guest-wrapper">
        <div>
            <Link :href="route('home')">
                <img src="/images/logo-pasion.png" alt="Logo Pasión de Hincha" class="logo-pasion">
            </Link>
        </div>

        <div class="guest-card">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.guest-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: var(--toni-azul-marino);
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 1.5rem;
}

.guest-logo {
    height: 80px;
    width: 80px;
    fill: white;
    margin-bottom: 1.5rem;
}

.guest-card {
    width: 100%;
    max-width: 28rem;
    background-color: var(--toni-celeste);
    padding: 1.5rem;
    border-radius: 1.5rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.logo-pasion {
    margin-bottom: 30px;
    width: 140px;
}
</style>
