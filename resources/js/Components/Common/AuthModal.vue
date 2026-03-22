<template>
    <div v-if="show" class="auth-modal-overlay" @click.self="$emit('close')">
        <div class="auth-modal-container">
            <button class="btn-close-modal" @click="$emit('close')">×</button>

            <div class="modal-header-img">
                <img src="/images/login.png" alt="Participa" class="img-fluid">
            </div>

            <div class="modal-content-body">
                <slot></slot>
            </div>

        </div>
    </div>
</template>

<script setup>
defineProps({ show: Boolean });
defineEmits(['close']);
</script>

<style scoped>
.auth-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #000c93c7;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
    overflow-y: auto;
}

.auth-modal-container {
    position: relative;
    margin-bottom: 50px;
}

.btn-close-modal {
    position: absolute;
    top: 0;
    right: 0px;
    background: var(--toni-amarillo);
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    line-height: 35px;
    font-weight: bold;
    font-size: 1.5rem;
    z-index: 100;
}

.modal-header-img {
    margin-bottom: -40px;
    /* Hace que se encime sobre el cuadro celeste */
    position: relative;
    z-index: 2;
    text-align: center;
}

.modal-content-body {
    width: 90%;
    display: block;
    margin: auto;
}

</style>