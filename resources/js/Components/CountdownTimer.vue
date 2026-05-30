<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const FECHA_OBJETIVO = new Date(2026, 5, 1, 0, 0, 0).getTime();

const restanteMs = ref(Math.max(FECHA_OBJETIVO - Date.now(), 0));
let intervaloId = null;

const esVisible = computed(() => restanteMs.value > 0);

const tiempoFormateado = computed(() => {
    const totalSegundos = Math.floor(restanteMs.value / 1000);
    const horas = Math.floor(totalSegundos / 3600);
    const minutos = Math.floor((totalSegundos % 3600) / 60);
    const segundos = totalSegundos % 60;

    return `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;
});

const actualizar = () => {
    const nuevoRestante = Math.max(FECHA_OBJETIVO - Date.now(), 0);
    restanteMs.value = nuevoRestante;

    if (nuevoRestante === 0 && intervaloId) {
        clearInterval(intervaloId);
        intervaloId = null;
    }
};

onMounted(() => {
    actualizar();

    if (restanteMs.value > 0) {
        intervaloId = setInterval(actualizar, 1000);
    }
});

onBeforeUnmount(() => {
    if (intervaloId) {
        clearInterval(intervaloId);
    }
});
</script>

<template>
    <div v-if="esVisible" class="countdown-wrapper">
        <p class="countdown-text mb-0">
            Quedan <strong>{{ tiempoFormateado }}</strong> horas para sumar puntos por tu empaque futbolero
        </p>
    </div>
</template>

<style scoped>
.countdown-wrapper {
    text-align: center;
}

.countdown-text {
    color: var(--toni-blanco);
    font-family: var(--fuente-principal);
    font-size: 2rem;
    line-height: 1.15;
}

.countdown-text strong {
    display: inline-block;
    font-size: 3rem;
    letter-spacing: 0.8px;
    transform: translateY(7px);
    margin-inline: 5px;
}
</style>
