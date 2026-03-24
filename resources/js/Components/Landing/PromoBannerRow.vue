<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="promo-banner-simple">
        <div class="container-fluid p-0">
            <!-- <img src="/images/banner-promo-desktop.png" alt="Promoción Toni Pasión del Hincha"
                class="img-fluid d-none d-md-block w-100"> -->
            <img src="/images/banner-promo-mobile.png" alt="Promoción Toni" class="img-fluid d-block">
        </div>
    </section>
</template>

<style scoped>
.promo-banner-simple {
    background-color: var(--toni-azul-marino);
    line-height: 0;
    padding-left: 1rem;
}

.promo-banner-simple {
    margin: auto;
    width: 60%;
}

.img-fluid {
    height: auto;
}

@media (max-width: 767px) {
    .promo-banner-simple {
        width: 100%;
    }
}
</style>