<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    productos: Array,
});

const page = usePage();
const mensaje = computed(() => page.props.flash?.mensaje);

// --- Formulario nuevo ---
const formNuevo = useForm({
    nombre: '',
});

const agregar = () => {
    formNuevo.post(route('admin.productos.store'), {
        onSuccess: () => formNuevo.reset(),
    });
};

// --- Edición inline ---
const editandoId = ref(null);
const formEditar = useForm({ nombre: '', activo: true });

const iniciarEdicion = (producto) => {
    editandoId.value = producto.id;
    formEditar.nombre = producto.nombre;
    formEditar.activo = producto.activo;
};

const cancelarEdicion = () => {
    editandoId.value = null;
    formEditar.reset();
};

const guardarEdicion = (producto) => {
    formEditar.put(route('admin.productos.update', producto.id), {
        onSuccess: () => {
            editandoId.value = null;
        },
    });
};

const eliminar = (producto) => {
    if (confirm(`¿Eliminar el producto "${producto.nombre}"?`)) {
        router.delete(route('admin.productos.destroy', producto.id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="container py-4">
            <h2 class="mb-4">Productos Participantes</h2>

            <div v-if="mensaje" class="alert alert-success mb-4">{{ mensaje }}</div>

            <!-- Formulario agregar nuevo producto -->
            <div class="prod-card mb-5">
                <h5 class="text-white mb-3">➕ Nuevo Producto</h5>

                <div class="mb-3">
                    <label class="form-label text-white-50">Nombre del producto</label>
                    <input
                        v-model="formNuevo.nombre"
                        type="text"
                        class="form-control prod-input"
                        placeholder="Ej: LECHE TONI"
                    />
                    <div v-if="formNuevo.errors.nombre" class="text-danger small mt-1">
                        {{ formNuevo.errors.nombre }}
                    </div>
                </div>

                <button
                    class="btn btn-warning px-4"
                    @click="agregar"
                    :disabled="formNuevo.processing"
                >
                    {{ formNuevo.processing ? 'Guardando...' : 'Agregar Producto' }}
                </button>
            </div>

            <!-- Lista de productos existentes -->
            <div v-if="productos.length === 0" class="text-white-50 text-center py-4">
                No hay productos registrados aún.
            </div>

            <div v-for="producto in productos" :key="producto.id" class="prod-card mb-3">

                <!-- Vista normal -->
                <template v-if="editandoId !== producto.id">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <span class="text-white fw-bold">{{ producto.nombre }}</span>
                            <span
                                class="badge"
                                :class="producto.activo ? 'bg-success' : 'bg-secondary'"
                            >
                                {{ producto.activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <button class="btn btn-sm btn-outline-warning" @click="iniciarEdicion(producto)">
                                ✏️ Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" @click="eliminar(producto)">
                                🗑️ Eliminar
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Vista edición inline -->
                <template v-else>
                    <div class="mb-3">
                        <label class="form-label text-white-50">Nombre</label>
                        <input
                            v-model="formEditar.nombre"
                            type="text"
                            class="form-control prod-input"
                        />
                        <div v-if="formEditar.errors.nombre" class="text-danger small mt-1">
                            {{ formEditar.errors.nombre }}
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input
                            id="activoCheck"
                            v-model="formEditar.activo"
                            type="checkbox"
                            class="form-check-input"
                        />
                        <label for="activoCheck" class="form-check-label text-white-50">
                            Producto activo (visible en el sitio)
                        </label>
                    </div>

                    <div class="d-flex gap-2">
                        <button
                            class="btn btn-warning btn-sm px-3"
                            @click="guardarEdicion(producto)"
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
.prod-card {
    background: #1e1e2e;
    border: 1px solid #444;
    border-radius: 10px;
    padding: 20px 24px;
}

.prod-input {
    border: 1px solid #555;
    border-radius: 6px;
}

.prod-input:focus {
    border-color: #FFD700;
    box-shadow: none;
}
</style>
