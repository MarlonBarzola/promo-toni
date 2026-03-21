<template>
    <div class="ranking-container shadow-lg p-4">
        <div class="ranking-header text-center">
            <img src="/images/titulo-ranking.png" alt="Tu Pasión de Hincha Toni"
                class="img-fluid img-promo-ranking mb-3">
        </div>

        <div class="ranking-list">
            <div v-for="(usuario, index) in ranking" :key="usuario.id"
                class="ranking-item d-flex align-items-center mb-2 px-3 py-2" :class="'pos-' + (index + 1)">

                <div class="ranking-position me-3">
                    <span v-if="index === 0">🥇</span>
                    <span v-else-if="index === 1">🥈</span>
                    <span v-else-if="index === 2">🥉</span>
                    <span v-else class="text-white fw-bold">{{ index + 1 }}</span>
                </div>

                <div class="ranking-name flex-grow-1 text-uppercase fw-bold text-white">
                    {{ usuario.name }} {{ usuario.apellido }}
                </div>

                <div class="ranking-points text-white fw-bold">
                    {{ String(usuario.codigos_count).padStart(3, '0') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    ranking: Array
});
</script>

<style scoped>
.ranking-container {
    background-color: var(--toni-celeste);
    border-radius: 25px;
    height: 100%;
}

.ranking-header {
    max-width: 350px;
    margin: 0 auto;
    margin-top: -55px;
}

.ranking-title {
    font-family: 'Bebas Neue', sans-serif;
    color: var(--toni-amarillo);
    font-size: 3rem;
    line-height: 0.8;
    margin-bottom: 0;
    -webkit-text-stroke: 1px var(--toni-azul-marino);
}

.ranking-subtitle {
    font-family: 'Bebas Neue', sans-serif;
    color: var(--toni-azul-marino);
    background-color: white;
    display: inline-block;
    padding: 0 10px;
    font-size: 1.5rem;
    transform: rotate(-2deg);
}

.ranking-item {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    transition: transform 0.2s;
}

.ranking-item:hover {
    transform: scale(1.02);
    background-color: rgba(255, 255, 255, 0.3);
}

/* Estilos especiales para el podio */
.pos-1 {
    background-color: rgba(255, 255, 255, 0.4);
    border: 2px solid gold;
}

.pos-2 {
    background-color: rgba(255, 255, 255, 0.35);
    border: 2px solid silver;
}

.pos-3 {
    background-color: rgba(255, 255, 255, 0.3);
    border: 2px solid #cd7f32;
}

.ranking-position {
    font-size: 1.5rem;
    width: 30px;
    text-align: center;
}

.ranking-points {
    font-size: 1.2rem;
    font-family: 'Courier New', monospace;
    /* Para estilo digital/contador */
}
</style>