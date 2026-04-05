<script setup>
import { ref } from 'vue';

const props = defineProps({
    src: { type: String, required: true },
    alt: { type: String, default: '' },
    imgClass: { type: String, default: '' },
    fetchpriority: { type: String, default: null },
    loading: { type: String, default: 'lazy' },
});

const loaded = ref(false);
const error = ref(false);

const onLoad = () => { loaded.value = true; };
const onError = () => { loaded.value = true; error.value = true; };
</script>

<template>
    <div class="lazy-image-wrapper" :class="{ 'is-loaded': loaded }">
        <!-- Skeleton shimmer -->
        <div v-if="!loaded" class="lazy-skeleton" aria-hidden="true"></div>

        <!-- Imagen real -->
        <img
            :src="src"
            :alt="alt"
            :class="['lazy-img', imgClass, { 'lazy-img--visible': loaded }]"
            :fetchpriority="fetchpriority"
            :loading="fetchpriority === 'high' ? 'eager' : loading"
            @load="onLoad"
            @error="onError"
        />
    </div>
</template>

<style scoped>
.lazy-image-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
}

/* Shimmer skeleton */
.lazy-skeleton {
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: rgba(255, 255, 255, 0.08);
    background-image: linear-gradient(
        to right,
        rgba(255, 255, 255, 0)   0%,
        rgba(255, 255, 255, 0.12) 20%,
        rgba(255, 255, 255, 0)   40%,
        rgba(255, 255, 255, 0)   100%
    );
    background-repeat: no-repeat;
    background-size: 800px 100%;
    animation: shimmer-img 1.4s infinite linear;
    z-index: 1;
}

@keyframes shimmer-img {
    0%   { background-position: -400px 0; }
    100% { background-position: 400px 0; }
}

/* Imagen oculta durante carga, visible con fade una vez cargada */
.lazy-img {
    display: block;
    width: 100%;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.lazy-img--visible {
    opacity: 1;
}
</style>
