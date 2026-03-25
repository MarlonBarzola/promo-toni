<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    codigos: Object,
    filters: Object
});

const desde = ref(props.filters?.desde || '');
const hasta = ref(props.filters?.hasta || '');
const search = ref(props.filters?.search || '');

let timeout = null;

// 🔎 buscador debounce
watch(search, (value) => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        buscar();
    }, 400);
});

const buscar = () => {
    router.get(route('admin.reportes'), {
        desde: desde.value,
        hasta: hasta.value,
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
};

const irPagina = (url) => {
    if (!url) return;

    router.visit(url, {
        preserveState: true,
        preserveScroll: true
    });
};

const exportar = () => {
    window.open(route('admin.export', {
        desde: desde.value,
        hasta: hasta.value,
        search: search.value
    }), '_blank');
};
</script>

<template>
    <AdminLayout>

        <h2 class="mb-4">Reportes de Códigos</h2>

        <!-- 🔎 FILTROS -->
        <div class="filters">

            <input type="date" v-model="desde" />
            <input type="date" v-model="hasta" />

            <input type="text" v-model="search" placeholder="Buscar usuario o código..." />

            <button @click="buscar">Filtrar</button>
            <button class="excel" @click="exportar">Excel</button>

        </div>

        <!-- 📊 TABLA -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in codigos.data" :key="item.id">
                    <td>{{ item.usuario.nombre }} {{ item.usuario.apellido }}</td>
                    <td>{{ item.usuario.cedula }}</td>
                    <td>{{ item.codigo_unico }}</td>
                    <td>{{ item.producto }}</td>
                    <td>
                        <span :class="'badge ' + item.estado">
                            {{ item.estado }}
                        </span>
                    </td>
                    <td>{{ item.fecha_formateada }}</td>
                </tr>
            </tbody>
        </table>

        <!-- EMPTY -->
        <div v-if="codigos.data.length === 0" class="empty">
            No hay resultados
        </div>

        <!-- PAGINACIÓN -->
        <div class="pagination">
            <button v-for="(link, i) in codigos.links" :key="i" v-html="link.label" :disabled="!link.url"
                @click="irPagina(link.url)" :class="{ active: link.active }" />
        </div>

    </AdminLayout>
</template>

<style scoped>
.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
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

.badge {
    padding: 4px 8px;
    border-radius: 6px;
    color: white;
}

.badge.aprobado {
    background: #10b981;
}

.badge.rechazado {
    background: #ef4444;
}

.badge.pendiente {
    background: #f59e0b;
}

.empty {
    text-align: center;
    padding: 40px;
    color: #777;
}
</style>