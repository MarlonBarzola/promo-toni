<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="promo-banner-simple">
        <div class="container-fluid p-0">
            <!-- <img src="/images/banner-promo-desktop.png" alt="Promoción Toni Pasión del Hincha"
                class="img-fluid d-none d-md-block w-100"> -->
            <img src="/images/banner-promo-mobile.png" alt="Promoción Toni" class="img-fluid d-block d-md-none w-100">
        </div>
    </section>
</template>

<style scoped>
.promo-banner-simple {
    background-color: var(--toni-azul-marino);
    line-height: 0;
    padding-left: 1rem;
}

.img-fluid {
    height: auto;
}
</style>