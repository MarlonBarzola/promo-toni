<script setup>
import { ref } from 'vue';
import LandingLayout from '@/Layouts/LandingLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    faqs: Array,
});

const indiceAbierto = ref(null);

const toggleFaq = (index) => {
    indiceAbierto.value = indiceAbierto.value === index ? null : index;
};
</script>

<template>
    <Head title="Preguntas Frecuentes" />
    <LandingLayout>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="faqs-container p-4">
                        <h2 class="text-center text-white fw-bold mb-5 text-uppercase">Preguntas Frecuentes</h2>

                        <div class="accordion">
                            <div v-for="(faq, index) in faqs" :key="index" class="faq-item mb-3">
                                <button @click="toggleFaq(index)"
                                    class="faq-question d-flex justify-content-between align-items-center w-100"
                                    :class="{ 'active': indiceAbierto === index }">
                                    <span class="fw-bold text-uppercase">{{ faq.pregunta }}</span>
                                    <span class="icon">{{ indiceAbierto === index ? '−' : '+' }}</span>
                                </button>

                                <Transition name="slide">
                                    <div v-if="indiceAbierto === index" class="faq-answer">
                                        <p class="mb-0 p-3 text-white">
                                            {{ faq.respuesta }}
                                        </p>
                                    </div>
                                </Transition>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
.faqs-container {
    background-color: var(--toni-celeste);
    border-radius: 20px;
}

.faq-item {
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    overflow: hidden;
}

.faq-question {
    background: none;
    border: none;
    padding: 15px 20px;
    color: white;
    text-align: left;
    transition: 0.3s;
    font-size: 0.9rem;
}

.faq-question:hover,
.faq-question.active {
    background-color: rgba(255, 255, 255, 0.1);
}

.faq-question.active {
    color: var(--toni-azul-oscuro);
}

.icon {
    font-size: 1.5rem;
    font-weight: bold;
}

.faq-answer {
    background-color: rgba(0, 0, 0, 0.1);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

/* Animación de apertura */
.slide-enter-active,
.slide-leave-active {
    transition: all 0.3s ease-out;
    max-height: 200px;
}

.slide-enter-from,
.slide-leave-to {
    max-height: 0;
    opacity: 0;
}
</style>