<script setup>
import ModalToni from '@/Components/Common/ModalToni.vue';
defineEmits(['close']);
</script>

<template>
    <ModalToni max-width="500px" @close="$emit('close')">
        <div class="p-4 text-center">
            <div class="flex items-center justify-center gap-3 items-center mb-3">
                <div class="icono" @click="$emit('close')" style="cursor:pointer">
                    <img src="/images/icon-modal.svg" class="img-fluid">
                </div>
                <h3 class="text-white text-uppercase">Código descartado</h3>
            </div>
            <p class="text-white mb-0 text-uppercase">Foto no cumple con parámetros de empaque abierto</p>
        </div>
    </ModalToni>
</template>

<style scoped>
.icono {
    font-size: 3rem;
    width: 60px;
}

p {
    font-family: var(--fuente-principal);
    font-size: 1.8rem;
    line-height: 1;
}
</style>
