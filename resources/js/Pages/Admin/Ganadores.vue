<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FlashToast from '@/Components/Admin/FlashToast.vue';
import UserAutocomplete from '@/Components/Admin/UserAutocomplete.vue';
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    ganadores: {
        type: Object,
        default: () => ({
            primero: null,
            segundo: null,
            primero_usuario: null,
            segundo_usuario: null,
        }),
    },
});

const form = useForm({
    primer_lugar: props.ganadores.primero,
    segundo_lugar: props.ganadores.segundo,
});

const primerSeleccionado = ref(props.ganadores.primero_usuario);
const segundoSeleccionado = ref(props.ganadores.segundo_usuario);

const submit = () => {
    form.post(route('admin.ganadores-ranking.store'));
};

const onSelectPrimer = (user) => {
    primerSeleccionado.value = user;
    form.clearErrors('primer_lugar');
};

const onSelectSegundo = (user) => {
    segundoSeleccionado.value = user;
    form.clearErrors('segundo_lugar');
};

const errorSeleccion = computed(() => {
    if (!form.primer_lugar || !form.segundo_lugar) {
        return null;
    }

    return form.primer_lugar === form.segundo_lugar
        ? 'El usuario seleccionado ya fue asignado a otra posicion.'
        : null;
});
</script>

<template>
    <AdminLayout>
        <div class="container py-4">
            <h2 class="mb-4">Ganadores</h2>

            <FlashToast />

            <div class="setting-card">
                <h5 class="text-white mb-1">Ganadores oficiales del concurso</h5>
                <p class="text-white-50 small mb-4">
                    Selecciona el Primer y Segundo Lugar. Solo se permiten usuarios existentes, sin duplicados por posicion.
                </p>

                <form @submit.prevent="submit" class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label text-white">Primer Lugar</label>
                        <UserAutocomplete
                            v-model="form.primer_lugar"
                            :selected-user="primerSeleccionado"
                            :disabled="form.processing"
                            placeholder="Buscar usuario..."
                            @update:selected-user="onSelectPrimer"
                        />
                        <div v-if="form.errors.primer_lugar" class="text-danger small mt-1 bg-white rounded px-2 py-1">
                            {{ form.errors.primer_lugar }}
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label text-white">Segundo Lugar</label>
                        <UserAutocomplete
                            v-model="form.segundo_lugar"
                            :selected-user="segundoSeleccionado"
                            :disabled="form.processing"
                            placeholder="Buscar usuario..."
                            @update:selected-user="onSelectSegundo"
                        />
                        <div v-if="form.errors.segundo_lugar" class="text-danger small mt-1 bg-white rounded px-2 py-1">
                            {{ form.errors.segundo_lugar }}
                        </div>
                    </div>

                    <div v-if="errorSeleccion" class="col-12">
                        <div class="text-danger small bg-white rounded px-2 py-1">
                            {{ errorSeleccion }}
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <button
                            class="btn btn-warning px-4"
                            type="submit"
                            :disabled="form.processing || !!errorSeleccion"
                        >
                            {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.setting-card {
    background: #1e1e2e;
    border: 1px solid #444;
    border-radius: 10px;
    padding: 24px;
}

</style>
