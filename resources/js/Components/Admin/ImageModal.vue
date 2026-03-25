<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    show: Boolean,
    image: String
});

const emit = defineEmits(['close']);

const cerrar = () => emit('close');

onMounted(() => {
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') cerrar();
    });
});
</script>

<template>
    <div v-if="show" class="modal-overlay" @click="cerrar">

        <!-- CONTENIDO (evita propagación) -->
        <div class="modal-content" @click.stop>
            <button class="close-btn" @click="cerrar">✕</button>
            <img :src="image" />
        </div>

    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* CONTENIDO centrado real */
.modal-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

/* IMAGEN */
.modal-content img {
    width: 100%;
    height: auto;
    max-height: 90vh;
    border-radius: 10px;
}

/* BOTÓN */
.close-btn {
    position: absolute;
    top: -15px;
    right: -15px;
    background: black;
    color: white;
    border: none;
    font-size: 20px;
    cursor: pointer;
    border-radius: 50%;
    width: 35px;
    height: 35px;
}
</style>