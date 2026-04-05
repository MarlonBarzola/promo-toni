<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    title: { type: String, required: true },
    description: { type: String, default: 'Participa en Tu Pasión de Hincha con Toni. Compra productos Toni, acumula puntos y gana paquetes para ir al Mundial 2026. ¡Regístrate ahora!' },
    image: { type: String, default: '/images/og-image.jpg' },
    canonical: { type: String, default: null },
});

const appUrl = import.meta.env.VITE_APP_URL || window.location.origin;
const fullImage = props.image.startsWith('http') ? props.image : `${appUrl}${props.image}`;
const canonicalUrl = props.canonical ?? window.location.href;
</script>

<template>
    <Head>
        <title>{{ title }}</title>
        <meta name="description" :content="description" head-key="description">
        <link rel="canonical" :href="canonicalUrl" head-key="canonical">

        <meta property="og:title" :content="title" head-key="og:title">
        <meta property="og:description" :content="description" head-key="og:description">
        <meta property="og:image" :content="fullImage" head-key="og:image">
        <meta property="og:url" :content="canonicalUrl" head-key="og:url">

        <meta name="twitter:title" :content="title" head-key="twitter:title">
        <meta name="twitter:description" :content="description" head-key="twitter:description">
        <meta name="twitter:image" :content="fullImage" head-key="twitter:image">
    </Head>
</template>
