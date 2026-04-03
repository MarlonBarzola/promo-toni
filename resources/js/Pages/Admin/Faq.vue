<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    faqs: Array,
});

const page = usePage();
const mensaje = computed(() => page.props.flash?.mensaje);

// --- Formulario nuevo ---
const formNuevo = useForm({
    pregunta: '',
    respuesta: '',
});

const agregarFaq = () => {
    formNuevo.post(route('admin.faq.store'), {
        onSuccess: () => formNuevo.reset(),
    });
};

// --- Edición inline ---
const editandoId = ref(null);
const formEditar = useForm({ pregunta: '', respuesta: '' });

const iniciarEdicion = (faq) => {
    editandoId.value = faq.id;
    formEditar.pregunta = faq.pregunta;
    formEditar.respuesta = faq.respuesta;
};

const cancelarEdicion = () => {
    editandoId.value = null;
    formEditar.reset();
};

const guardarEdicion = (faq) => {
    formEditar.put(route('admin.faq.update', faq.id), {
        onSuccess: () => {
            editandoId.value = null;
        },
    });
};

const eliminar = (faq) => {
    if (confirm(`¿Eliminar la pregunta "${faq.pregunta}"?`)) {
        router.delete(route('admin.faq.destroy', faq.id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="container py-4">
            <h2 class="mb-4">Preguntas Frecuentes</h2>

            <div v-if="mensaje" class="alert alert-success mb-4">{{ mensaje }}</div>

            <!-- Formulario agregar nueva pregunta -->
            <div class="faq-card mb-5">
                <h5 class="text-white mb-3">➕ Nueva Pregunta</h5>

                <div class="mb-3">
                    <label class="form-label text-white-50">Pregunta</label>
                    <input
                        v-model="formNuevo.pregunta"
                        type="text"
                        class="form-control faq-input"
                        placeholder="Escribe la pregunta..."
                    />
                    <div v-if="formNuevo.errors.pregunta" class="text-danger small mt-1">
                        {{ formNuevo.errors.pregunta }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white-50">Respuesta</label>
                    <textarea
                        v-model="formNuevo.respuesta"
                        class="form-control faq-input"
                        rows="3"
                        placeholder="Escribe la respuesta..."
                    />
                    <div v-if="formNuevo.errors.respuesta" class="text-danger small mt-1">
                        {{ formNuevo.errors.respuesta }}
                    </div>
                </div>

                <button
                    class="btn btn-warning px-4"
                    @click="agregarFaq"
                    :disabled="formNuevo.processing"
                >
                    {{ formNuevo.processing ? 'Guardando...' : 'Agregar Pregunta' }}
                </button>
            </div>

            <!-- Lista de preguntas existentes -->
            <div v-if="faqs.length === 0" class="text-white-50 text-center py-4">
                No hay preguntas registradas aún.
            </div>

            <div v-for="faq in faqs" :key="faq.id" class="faq-card mb-3">

                <!-- Vista normal -->
                <template v-if="editandoId !== faq.id">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <p class="text-white mb-1">{{ faq.pregunta }}</p>
                            <p class="text-white-50 mb-0 small">{{ faq.respuesta }}</p>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <button class="btn btn-sm btn-outline-warning" @click="iniciarEdicion(faq)">
                                ✏️ Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" @click="eliminar(faq)">
                                🗑️ Eliminar
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Vista edición inline -->
                <template v-else>
                    <div class="mb-3">
                        <label class="form-label text-white-50">Pregunta</label>
                        <input
                            v-model="formEditar.pregunta"
                            type="text"
                            class="form-control faq-input"
                        />
                        <div v-if="formEditar.errors.pregunta" class="text-danger small mt-1">
                            {{ formEditar.errors.pregunta }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white-50">Respuesta</label>
                        <textarea
                            v-model="formEditar.respuesta"
                            class="form-control faq-input"
                            rows="3"
                        />
                        <div v-if="formEditar.errors.respuesta" class="text-danger small mt-1">
                            {{ formEditar.errors.respuesta }}
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button
                            class="btn btn-warning btn-sm px-3"
                            @click="guardarEdicion(faq)"
                            :disabled="formEditar.processing"
                        >
                            {{ formEditar.processing ? 'Guardando...' : 'Guardar' }}
                        </button>
                        <button class="btn btn-secondary btn-sm px-3" @click="cancelarEdicion">
                            Cancelar
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.faq-card {
    background: #1e1e2e;
    border: 1px solid #444;
    border-radius: 10px;
    padding: 20px 24px;
}

.faq-input {
    border: 1px solid #555;
    border-radius: 6px;
}

.faq-input:focus {
    border-color: #FFD700;
    box-shadow: none;
}
</style>
