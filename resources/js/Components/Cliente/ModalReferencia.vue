<script setup>
import ModalToni from '@/Components/Common/ModalToni.vue';
defineEmits(['close']);
</script>

<template>
    <ModalToni max-width="800px" @close="$emit('close')">
        <div class="row align-items-center g-0">
            <div class="col-6 text-center p-3 rounded-start">
                <img src="/images/producto.png" class="img-fluid">
            </div>
            <div class="col-6 p-3">
                <h3 class="text-white text-uppercase mb-3 lh-1">
                    Carga una foto clara del código en el envase
                </h3>
                <p class="text-white mb-0 lh-1 fw-bold">
                    Necesitamos una foto para verificar la veracidad del código
                </p>
            </div>
        </div>
    </ModalToni>
</template>
