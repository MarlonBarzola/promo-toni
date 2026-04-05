<script setup>
import { Link } from '@inertiajs/vue3';
import LazyImage from '@/Components/Common/LazyImage.vue';
defineProps({
    ranking: Array
});

</script>
<template>
    <div class="ranking-container p-4">
        <div class="ranking-header text-center">
            <LazyImage src="/images/titulo-ranking.png" alt="Tu Pasión de Hincha Toni"
                img-class="img-promo-ranking mb-3" />
        </div>

        <div class="ranking-list">
            <div v-if="ranking.length === 0" class="text-center text-white py-4">
                <p class="small">Aún no hay ranking disponible.</p>
            </div>
            <template v-else>
                <div v-for="(usuario, index) in ranking" :key="usuario.id"
                    class="ranking-item d-flex align-items-center mb-2 px-3 py-2" :class="'pos-' + (index + 1)">

                    <div class="ranking-position me-3">
                        <span v-if="index === 0"><img src="/images/rank-1.svg" alt="Primer Lugar"></span>
                        <span v-else-if="index === 1"><img src="/images/rank-2.svg" alt="Segundo Lugar"></span>
                        <span v-else-if="index === 2"><img src="/images/rank-3.svg" alt="Tercer Lugar"></span>
                        <span v-else class="text-white fw-bold">{{ index + 1 }}</span>
                    </div>

                    <div class="ranking-name flex-grow-1 fw-bold">
                        {{ usuario.usuario }}
                    </div>

                    <div class="ranking-points fw-bold">
                        {{ String(usuario.codigos_count).padStart(3, '0') }}
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<style scoped>
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

.img-ranking {
    width: 500px;
    margin: 0 auto;
    margin-top: 0px;
    margin-top: -4rem;
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

.ranking-points {
    font-size: 1.2rem;
    font-family: 'Courier New', monospace;
    color: var(--toni-azul-marino);
    /* Para estilo digital/contador */
}

@media (max-width: 765px) {
    .ranking-container {
        max-width: 100%;
    }
    
    .img-ranking {
        width: 75%;
    }
}
</style>