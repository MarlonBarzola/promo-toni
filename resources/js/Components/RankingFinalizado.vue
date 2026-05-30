<script setup>
import LazyImage from '@/Components/Common/LazyImage.vue';

defineProps({
    ranking: Array,
});
</script>

<template>
    <div class="ranking-finalizado">
        <div class="ranking-blur-layer">
            <div class="ranking-container p-4">
                <div class="ranking-header text-center">
                    <LazyImage src="/images/titulo-ranking.png" alt="Tu Pasion de Hincha Toni"
                        img-class="img-promo-ranking mb-3" />
                </div>

                <div class="ranking-list">
                    <div v-if="ranking.length === 0" class="text-center text-white py-4">
                        <p class="small">Aun no hay ranking disponible.</p>
                    </div>
                    <template v-else>
                        <div v-for="(usuario, index) in ranking" :key="usuario.id"
                            class="ranking-item d-flex align-items-center mb-2 px-3 py-2" :class="'pos-' + (index + 1)">

                            <div class="ranking-position me-3">
                                <span v-if="index === 0"><img src="/images/rank-1.svg" alt="Primer Lugar"></span>
                                <span v-else-if="index === 1"><img src="/images/rank-2.svg" alt="Segundo Lugar"></span>
                                <span v-else-if="index === 2"><img src="/images/rank-3.svg" alt="Tercer Lugar"></span>
                            </div>

                            <div class="ranking-name flex-grow-1 fw-bold">
                                {{ usuario.usuario }}
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="ranking-overlay" aria-hidden="true">
            <p class="mb-0">Ranking finalizado.</p>
            <p class="mb-0">Estamos revisando empaques pendientes.</p>
            <p class="mb-0">Pronto anunciaremos los ganadores.</p>
        </div>
    </div>
</template>

<style scoped>
.ranking-finalizado {
    position: relative;
}

.ranking-blur-layer {
    filter: blur(5px);
    pointer-events: none;
    user-select: none;
}

.ranking-overlay {
    align-items: center;
    border-radius: 25px;
    color: var(--toni-azul-marino);
    display: flex;
    flex-direction: column;
    font-family: var(--fuente-principal);
    font-size: 1.8rem;
    gap: 8px;
    inset: 0;
    justify-content: center;
    padding: 24px;
    position: absolute;
    text-align: center;
    line-height: 1;
}

.ranking-container {
    background-color: var(--toni-celeste);
    border-radius: 25px;
    border-bottom: 12px solid var(--toni-amarillo);
    min-height: 40vh;
}

.ranking-list {
    padding-left: 15px;
}

.ranking-header {
    position: relative;
    max-width: 270px;
    margin: 0 auto;
    margin-top: -90px;
    z-index: 1;
}

.ranking-name {
    color: var(--toni-azul-marino);
}

.ranking-item {
    background-color: var(--toni-blanco);
    border-radius: 15px;
    position: relative;
    transition: transform 0.2s;
    padding-left: 50px !important;
}

.ranking-position {
    font-size: 1.5rem;
    width: 50px;
    text-align: center;
    position: absolute;
    top: -3px;
    left: -20px;
}

@media (max-width: 765px) {
    .ranking-overlay {
        font-size: 1.1rem;
        gap: 6px;
        padding: 20px 16px;
    }

    .ranking-container {
        max-width: 100%;
    }
}
</style>
