<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FlashToast from '@/Components/Admin/FlashToast.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    key:   'registro_habilitado',
    value: props.settings.registro_habilitado,
});

const toggle = (nuevoValor) => {
    form.value = nuevoValor;
    form.post(route('admin.settings.update'));
};
</script>

<template>
    <AdminLayout>
        <div class="container py-4">
            <h2 class="mb-4">Configuración General</h2>

            <FlashToast />

            <div class="setting-card">
                <div class="d-flex justify-content-between align-items-center gap-4 flex-wrap">
                    <div>
                        <h5 class="text-white mb-1">Registro de usuarios</h5>
                        <p class="text-white-50 small mb-0">
                            Controla si los usuarios pueden registrarse e iniciar sesión en el sitio.
                            Al desactivarlo se ocultarán los botones de acceso en la landing.
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <span class="badge-estado" :class="form.value ? 'badge--activo' : 'badge--inactivo'">
                            {{ form.value ? 'ACTIVO' : 'INACTIVO' }}
                        </span>

                        <button
                            class="btn btn-sm px-4"
                            :class="form.value ? 'btn-outline-danger' : 'btn-success'"
                            :disabled="form.processing"
                            @click="toggle(!form.value)"
                        >
                            {{ form.processing ? '...' : (form.value ? 'Desactivar' : 'Activar') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Placeholder para futuras configuraciones -->
            <!-- 
            <div class="setting-card mt-3">
                <h5 class="text-white mb-1">Otra configuración</h5>
                ...
            </div>
            -->
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

.badge-estado {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 999px;
    letter-spacing: 0.5px;
}

.badge--activo  { background: #14532d; color: #86efac; border: 1px solid #22c55e; }
.badge--inactivo { background: #3b0764; color: #d8b4fe; border: 1px solid #a855f7; }
</style>
