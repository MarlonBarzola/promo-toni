<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FlashToast from '@/Components/Admin/FlashToast.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    usuarios: Object,
    filters:  Object,
});

const toast  = ref(null);
const desde  = ref(props.filters?.desde  || '');
const hasta  = ref(props.filters?.hasta  || '');
const search = ref(props.filters?.search || '');
const ciudad = ref(props.filters?.ciudad || '');

let timeout = null;

watch(search, () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => buscar(), 400);
});

watch(ciudad, () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => buscar(), 400);
});

const validarFechas = () => {
    if (desde.value && !hasta.value) {
        toast.value?.mostrar('Debes ingresar la fecha final.', 'error');
        return false;
    }
    if (!desde.value && hasta.value) {
        toast.value?.mostrar('Debes ingresar la fecha inicial.', 'error');
        return false;
    }
    if (desde.value && hasta.value && hasta.value < desde.value) {
        toast.value?.mostrar('La fecha final debe ser mayor o igual a la fecha inicial.', 'error');
        return false;
    }
    return true;
};

const buscar = () => {
    if (!validarFechas()) return;

    router.get(route('admin.reporte-usuarios'), {
        desde:  desde.value,
        hasta:  hasta.value,
        search: search.value,
        ciudad: ciudad.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

const irPagina = (url) => {
    if (!url) return;
    router.visit(url, { preserveState: true, preserveScroll: true });
};

const exportar = () => {
    if (!validarFechas()) return;

    window.open(route('admin.export-usuarios', {
        desde:  desde.value,
        hasta:  hasta.value,
        search: search.value,
        ciudad: ciudad.value,
    }), '_blank');
};

const limpiar = () => {
    desde.value  = '';
    hasta.value  = '';
    search.value = '';
    ciudad.value = '';
    buscar();
};

const hayFiltros = computed(() =>
    !!desde.value || !!hasta.value || !!search.value || !!ciudad.value
);
</script>

<template>
    <AdminLayout>

        <FlashToast ref="toast" />

        <h2 class="mb-4">Reporte de Usuarios Registrados</h2>

        <!-- FILTROS -->
        <div class="filters">
            <input type="date" v-model="desde" />
            <input type="date" v-model="hasta" />
            <input type="text" v-model="search" placeholder="Nombre, cédula o email..." />
            <input type="text" v-model="ciudad" placeholder="Ciudad..." />
            <button @click="buscar">Filtrar</button>
            <button class="excel" @click="exportar">Excel</button>
            <button class="limpiar" @click="limpiar" :disabled="!hayFiltros">Limpiar</button>
        </div>

        <!-- TABLA USUARIOS -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th>Puntos</th>
                    <th>Verificado</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="u in usuarios.data" :key="u.id">
                    <td>{{ u.nombre }} {{ u.apellido }}</td>
                    <td>{{ u.cedula }}</td>
                    <td>{{ u.email }}</td>
                    <td>{{ u.telefono }}</td>
                    <td>{{ u.ciudad }}</td>
                    <td>{{ u.puntos_acumulados }}</td>
                    <td>
                        <span :class="u.email_verified_at ? 'verificado-si' : 'verificado-no'">
                            {{ u.email_verified_at ? 'Sí' : 'No' }}
                        </span>
                    </td>
                    <td>{{ u.fecha_formateada }}</td>
                </tr>
            </tbody>
        </table>

        <!-- EMPTY -->
        <div v-if="usuarios.data.length === 0" class="empty">
            No hay resultados
        </div>

        <!-- PAGINACIÓN -->
        <div class="pagination">
            <button
                v-for="(link, i) in usuarios.links"
                :key="i"
                v-html="link.label"
                :disabled="!link.url"
                @click="irPagina(link.url)"
                :class="{ active: link.active }"
            />
        </div>

    </AdminLayout>
</template>

<style scoped>
.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.filters input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.filters button {
    padding: 8px 12px;
    border: none;
    background: #111827;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}

.filters .excel {
    background: #10b981;
}

.filters .limpiar {
    background: #6b7280;
}

.filters .limpiar:disabled {
    background: #d1d5db;
    cursor: not-allowed;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.table th,
.table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    text-align: left;
}

.empty {
    text-align: center;
    padding: 40px;
    color: #777;
}

.pagination {
    display: flex;
    gap: 4px;
    margin-top: 16px;
}

.pagination button {
    padding: 6px 10px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
}

.pagination button.active {
    background: #111827;
    color: white;
    border-color: #111827;
}

.pagination button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.verificado-si {
    background: #10b981;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.verificado-no {
    background: #ef4444;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
}
</style>
