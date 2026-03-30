<script setup>
defineProps({
    maxWidth: { type: String, default: '800px' },
});
defineEmits(['close']);
</script>

<template>
    <div class="modal-overlay" @click.self="$emit('close')">
        <div class="modal-box" :style="{ maxWidth }">
            <button class="btn-cerrar" @click="$emit('close')">&#10005;</button>
            <slot />
        </div>
    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 51, 160, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-box {
    background-color: var(--toni-celeste);
    width: 90%;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    border: 3px solid white;
}

:slotted(h3) {
    font-family: var(--fuente-principal);
    font-size: 1.8rem;
    line-height: 1.1;
}

.btn-cerrar {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    z-index: 10;
}
</style>
