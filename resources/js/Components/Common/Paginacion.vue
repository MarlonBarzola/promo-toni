<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    paginacion: { type: Object, required: true },
    links: { type: Array, required: true },
    tabParam: { type: String, default: 'mis-codigos' },
});

const navegarPagina = (url) => {
    const scrollY = window.scrollY;
    router.visit(`${url}&tab=${props.tabParam}`, {
        preserveScroll: true,
        onFinish: () => window.scrollTo({ top: scrollY, behavior: 'instant' }),
    });
};
</script>

<template>
    <div v-if="links.length > 3" class="paginacion mt-4">
        <button v-if="paginacion.prev?.url"
            @click="navegarPagina(paginacion.prev.url)"
            class="pag-nav">&#9664;</button>
        <span v-else class="pag-nav pag-nav--disabled">&#9664;</span>

        <div class="pag-pages">
            <template v-for="(link, k) in paginacion.pages" :key="k">
                <button v-if="link.url"
                    @click="navegarPagina(link.url)"
                    class="pag-num" :class="{ 'pag-num--active': link.active }"
                    v-html="link.label" />
                <span v-else class="pag-dots" v-html="link.label"></span>
            </template>
        </div>

        <button v-if="paginacion.next?.url"
            @click="navegarPagina(paginacion.next.url)"
            class="pag-nav">&#9654;</button>
        <span v-else class="pag-nav pag-nav--disabled">&#9654;</span>
    </div>
</template>

<style scoped>
.paginacion {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.pag-nav {
    color: var(--toni-amarillo);
    font-size: 1rem;
    font-weight: bold;
    padding: 2px 6px;
    flex-shrink: 0;
    line-height: 1;
    background: none;
    border: none;
    cursor: pointer;
}

.pag-nav--disabled {
    color: rgba(255, 255, 255, 0.25);
    cursor: not-allowed;
}

.pag-pages {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

.pag-num {
    color: white;
    font-weight: bold;
    font-size: 0.85rem;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
    background: none;
    border: none;
    cursor: pointer;
}

:deep(.pag-num) {
    color: white;
}

.pag-num--active {
    background-color: var(--toni-azul-marino);
}

.pag-dots {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.85rem;
    padding: 0 2px;
}
</style>
