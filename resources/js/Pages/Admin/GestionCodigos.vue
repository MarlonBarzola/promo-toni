<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ImageModal from '@/Components/Admin/ImageModal.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { watch } from 'vue';

const props = defineProps({
    codigos: Object,
    stats: Object,
    filters: Object
});

const search = ref(props.filters?.search || '');

let timeout = null;

watch(search, (value) => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        router.get(route('admin.index'), {
            estado: filtro.value,
            search: value
        }, {
            preserveState: true,
            replace: true
        });
    }, 400); // debounce
});

const filtro = ref(props.filters?.estado || 'pendiente');

const modal = ref(false);
const imagenSeleccionada = ref(null);

const abrirImagen = (src) => {
    imagenSeleccionada.value = src;
    modal.value = true;
};

const cambiarFiltro = (estado) => {
    filtro.value = estado;

    router.get(route('admin.index'), { estado }, {
        preserveState: true,
        replace: true
    });
};

const actualizarEstado = (id, estado) => {
    router.patch(route('admin.validar', id), { estado }, {
        preserveScroll: true
    });
};

const irPagina = (url) => {
    if (!url) return;

    router.visit(url, {
        preserveScroll: true,
        preserveState: true
    });
};
</script>

<template>
    <AdminLayout>

        <!-- 🔥 STATS -->
        <div class="admin-stats">
            <div class="stat pendiente">
                <span>Pendientes</span>
                <strong>{{ stats.pendientes }}</strong>
            </div>
            <div class="stat aprobado">
                <span>Aprobados</span>
                <strong>{{ stats.aprobados }}</strong>
            </div>
            <div class="stat rechazado">
                <span>Rechazados</span>
                <strong>{{ stats.rechazados }}</strong>
            </div>
        </div>

        <!-- 🔎 BUSCADOR -->
        <div class="admin-search">
            <input type="text" v-model="search" placeholder="Buscar por nombre, apellido, cédula o código..." />
        </div>

        <!-- 🔎 FILTROS -->
        <div class="admin-filters">
            <button :class="{ active: filtro === 'pendiente' }" @click="cambiarFiltro('pendiente')">
                Pendientes
            </button>

            <button :class="{ active: filtro === 'aprobado' }" @click="cambiarFiltro('aprobado')">
                Aprobados
            </button>

            <button :class="{ active: filtro === 'rechazado' }" @click="cambiarFiltro('rechazado')">
                Rechazados
            </button>
        </div>

        <!-- 📦 GRID -->
        <div v-if="codigos.data.length > 0" class="admin-grid">

            <div v-for="item in codigos.data" :key="item.id" class="admin-card">

                <div class="admin-card-header">
                    <strong>{{ item.usuario.nombre }} {{ item.usuario.apellido }}</strong>
                    <small>{{ item.codigo_unico }}</small>
                </div>

                <!-- IMÁGENES -->
                <div class="admin-images">

                    <div class="image-box">
                        <span>Foto del código</span>
                        <img :src="'/storage/' + item.foto_codigo"
                            @click="abrirImagen('/storage/' + item.foto_codigo)" />
                    </div>

                    <div class="image-box">
                        <span>Foto del empaque</span>
                        <img :src="'/storage/' + item.foto_empaque"
                            @click="abrirImagen('/storage/' + item.foto_empaque)" />
                    </div>

                </div>

                <!-- ACCIONES -->
                <div v-if="item.estado === 'pendiente'" class="admin-actions">
                    <button class="btn-approve" @click="actualizarEstado(item.id, 'aprobado')">
                        Aprobar
                    </button>
                    <button class="btn-reject" @click="actualizarEstado(item.id, 'rechazado')">
                        Rechazar
                    </button>
                </div>

                <!-- ESTADO -->
                <div v-else class="estado-badge" :class="item.estado">
                    {{ item.estado.toUpperCase() }}
                </div>

            </div>

        </div>

        <!-- EMPTY -->
        <div v-else class="empty-state">
            <h3>No hay códigos en estado {{ filtro }}.</h3>
        </div>

        <!-- 🔢 PAGINACIÓN -->
        <div class="pagination" v-if="codigos.links.length > 3">
            <button v-for="(link, index) in codigos.links" :key="index" v-html="link.label" :disabled="!link.url"
                :class="{ active: link.active }" @click="irPagina(link.url)" />
        </div>

        <!-- MODAL -->
        <ImageModal :show="modal" :image="imagenSeleccionada" @close="modal = false" />

    </AdminLayout>
</template>

<style scoped>
/* STATS */
.admin-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}

.stat {
    flex: 1;
    background: white;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.stat span {
    font-size: 0.9rem;
    color: #666;
}

.stat strong {
    display: block;
    font-size: 1.6rem;
}

.stat.pendiente {
    border-left: 5px solid #f59e0b;
}

.stat.aprobado {
    border-left: 5px solid #10b981;
}

.stat.rechazado {
    border-left: 5px solid #ef4444;
}

/* FILTROS */
.admin-filters {
    margin-bottom: 20px;
}

.admin-filters button {
    margin-right: 10px;
    padding: 8px 16px;
    border: none;
    background: #e5e7eb;
    border-radius: 20px;
    cursor: pointer;
}

.admin-filters button.active {
    background: #111827;
    color: white;
}

/* GRID */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.admin-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.admin-card-header {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.admin-images {
    display: flex;
    gap: 10px;
    padding: 15px;
}

.image-box {
    width: 50%;
    text-align: center;
}

.image-box span {
    font-size: 12px;
    color: #666;
}

.image-box img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
}

/* ACCIONES */
.admin-actions {
    display: flex;
}

.admin-actions button {
    flex: 1;
    padding: 12px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.btn-approve {
    background: #10b981;
    color: white;
}

.btn-reject {
    background: #ef4444;
    color: white;
}

/* ESTADO */
.estado-badge {
    text-align: center;
    padding: 12px;
    font-weight: bold;
}

.estado-badge.aprobado {
    background: #d1fae5;
    color: #065f46;
}

.estado-badge.rechazado {
    background: #fee2e2;
    color: #7f1d1d;
}

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 60px;
    color: #777;
}

/* PAGINACIÓN */
.pagination {
    margin-top: 30px;
    text-align: center;
}

.pagination button {
    margin: 3px;
    padding: 8px 12px;
    border: none;
    background: #e5e7eb;
    cursor: pointer;
    border-radius: 6px;
}

.pagination button.active {
    background: #111827;
    color: white;
}

.pagination button:disabled {
    opacity: 0.5;
}
</style>