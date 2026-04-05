<script setup>
import { Head } from '@inertiajs/vue3';
import LandingLayout from '@/Layouts/LandingLayout.vue';

const props = defineProps({
    productos: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Productos Participantes" />
    <LandingLayout>
        <div class="bg-malla">
            <div class="container">
                <div class="malla-container">
                    <div class="malla-content w-100">
                        <div class="content-container">
                            <h2 class="text-center text-white fw-bold mb-4 text-uppercase titulo">
                                Productos Participantes
                            </h2>

                            <ul class="lista-productos">
                                <li v-for="(producto, i) in productos" :key="producto.id" class="producto-item">
                                    <span class="numero">{{ String(i + 1).padStart(2, '0') }}</span>
                                    <span class="nombre">{{ producto.nombre }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
.content-container {
    background-color: var(--toni-celeste);
    border-radius: 20px;
    min-height: 538px;
    padding: 30px 30px;
    max-width: 600px;
    margin: 0 auto;
}

.titulo {
    font-family: var(--fuente-principal);
    font-size: 2rem;
    color: var(--toni-azul-oscuro) !important;
}

.lista-productos {
    list-style: none;
    padding: 0;
    margin: 0;
}

.producto-item {
    display: flex;
    align-items: center;
    gap: 16px;
    background-color: white;
    border-radius: 12px;
    padding: 12px 20px;
    margin-bottom: 10px;
    font-weight: bold;
    color: var(--toni-azul-oscuro);
}

.numero {
    font-family: var(--fuente-principal);
    font-size: 1.4rem;
    color: var(--toni-celeste);
    min-width: 32px;
}

.nombre {
    font-size: 1rem;
    letter-spacing: 0.5px;
}
</style>
