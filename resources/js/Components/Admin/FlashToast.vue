<script setup>
import { ref, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    tipo: {
        type: String,
        default: 'exito', // 'exito' | 'error'
    },
    duracion: {
        type: Number,
        default: 5000,
    },
});

const visible = ref(false);
const mensaje = ref('');
let   timer   = null;

const cerrar = () => {
    visible.value = false;
    clearTimeout(timer);
};

const mostrar = (msg) => {
    if (!msg) return;
    clearTimeout(timer);
    visible.value = false;
    mensaje.value = msg;
    requestAnimationFrame(() => {
        visible.value = true;
        timer = setTimeout(cerrar, props.duracion);
    });
};

const unsubscribe = router.on('success', (event) => {
    const flash = event.detail.page.props.flash?.mensaje;
    mostrar(flash);
});

onUnmounted(() => unsubscribe());
</script>

<template>
    <Teleport to="body">
        <Transition name="toast">
            <div
                v-if="visible && mensaje"
                class="flash-toast"
                :class="tipo === 'error' ? 'flash-toast--error' : 'flash-toast--exito'"
                role="alert"
            >
                <span class="flash-toast__icono">{{ tipo === 'error' ? '❌' : '✅' }}</span>
                <span class="flash-toast__texto">{{ mensaje }}</span>
                <button class="flash-toast__cerrar" @click="cerrar" aria-label="Cerrar">✕</button>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.flash-toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 9999;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    max-width: 380px;
    padding: 14px 18px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
    font-size: 0.9rem;
    line-height: 1.4;
}

.flash-toast--exito {
    background: #14532d;
    border: 1px solid #22c55e;
    color: #bbf7d0;
}

.flash-toast--error {
    background: #450a0a;
    border: 1px solid #ef4444;
    color: #fecaca;
}

.flash-toast__icono {
    font-size: 1.2rem;
    flex-shrink: 0;
    line-height: 1.2;
}

.flash-toast__texto {
    flex: 1;
    color: inherit;
}

.flash-toast__cerrar {
    background: none;
    border: none;
    cursor: pointer;
    color: inherit;
    opacity: 0.6;
    font-size: 0.85rem;
    padding: 0;
    flex-shrink: 0;
    line-height: 1;
}

.flash-toast__cerrar:hover {
    opacity: 1;
}

.toast-enter-active,
.toast-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translateY(16px);
}
</style>

