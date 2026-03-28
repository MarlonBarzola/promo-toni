<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="promo-banner-simple">
        <div class="container-fluid p-0">
            <img src="/images/promo-banner.png" alt="Promoción Toni" class="img-fluid d-block">
        </div>
    </section>
</template>

<style scoped>
.img-fluid {
    height: auto;
}

@media (max-width: 767px) {
    .promo-banner-simple {
        width: 100%;
    }
}
</style>