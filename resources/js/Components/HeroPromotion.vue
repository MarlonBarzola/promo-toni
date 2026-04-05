<script setup>
import LazyImage from '@/Components/Common/LazyImage.vue';
defineProps({
    imageSrc: {
        type: String,
        default: '/images/logo-lonchera.png',
    },
});
</script>

<template>
    <div class="hero-main">
        <div class="hero-img-wrapper d-none d-md-block">
            <LazyImage src="/images/logo-lonchera.png" alt="Tu Pasión de Hincha Toni"
                img-class="img-promo-main" fetchpriority="high" />
        </div>
        <div class="hero-img-wrapper d-block d-md-none">
            <LazyImage src="/images/logo-lonchera-mobile.png" alt="Tu Pasión de Hincha Toni"
                img-class="img-promo-main" fetchpriority="high" />
        </div>
        <slot />
    </div>
</template>

<style scoped>
.hero-main {
    align-items: center;
    background-color: var(--toni-azul-marino);
    background-image: url("/images/bg-cancha.svg");
    background-position: center;
    background-repeat: no-repeat;
    background-size: 110%;
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
    position: relative;
    margin-bottom: -8rem;
}

.z-10 {
    z-index: 1;
}

.hero-img-wrapper {
    width: 100%;
    max-width: 1024px;
    position: relative;
    z-index: 1;
}

.img-promo-main {
    width: 100%;
}

@media (max-width: 991px) {
    .hero-main {
        background-image: none;
        height: auto;
        padding: 0;
        margin-bottom: 0;
    }
}
</style>