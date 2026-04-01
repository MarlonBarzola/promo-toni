<script setup>
import { Head } from '@inertiajs/vue3';
import LandingLayout from '@/Layouts/LandingLayout.vue';

const props = defineProps({
    ganadores: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>

    <Head title="Ganadores" />
    <LandingLayout>
        <div class="bg-malla">
            <div class="container">
                <div class="malla-container">
                    <div class="img-malla">
                        <img class="d-none d-lg-block" src="/images/ganadores-semanales.png"
                            alt="Gana premios semanales" />
                        <img class="d-block d-lg-none" src="/images/ganadores-semanales-mobile.png"
                            alt="Gana premios semanales" />
                    </div>
                    <div class="malla-content">
                        <div class="content-container">
                            <img src="/images/titulo-ganadores.png" alt="Ganadores semanales"
                                class="mb-2 titulo-ganadores">

                            <div v-if="ganadores.length === 0" class="sin-ganadores">
                                <p>Aún no hay ganadores publicados esta semana.</p>
                                <p>¡Sigue participando!</p>
                            </div>

                            <ul v-else class="lista-ganadores">
                                <li class="ganador-header">
                                    <div>Usuario</div>
                                    <div>Cédula de identidad</div>
                                </li>
                                <li v-for="(g, i) in ganadores" :key="i" class="ganador-item">
                                    <div>{{ g.usuario }}</div>
                                    <div>{{ g.cedula }}</div>
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
    padding: 0 20px 30px;
}

.titulo-ganadores {
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
    margin-bottom: 0px;
    transform: translateY(-55px);
}

.sin-ganadores {
    text-align: center;
    color: white;
    padding: 40px 10px;
    font-weight: 600;
    font-size: 1rem;
    opacity: 0.85;
}

.lista-ganadores {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: -4rem;
    padding-bottom: 2rem;
}

.ganador-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 16px 4px;
    color: var(--toni-blanco);
    font-family: var(--fuente-principal);
    font-size: 1.3rem;
    text-transform: uppercase;
}

.ganador-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--toni-blanco);
    border-radius: 12px;
    padding: 5px 16px;
    color: var(--toni-azul-oscuro);
    font-family: var(--fuente-principal);
    font-size: 1.5rem;
}

.ganador-info {
    display: flex;
    flex-direction: column;
}

@media (max-width: 992px) {
    .img-malla {
        margin-bottom: -2.4rem;
        position: relative;
    }
}
</style>
