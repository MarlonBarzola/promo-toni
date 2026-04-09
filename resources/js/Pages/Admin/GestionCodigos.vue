<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ImageModal from '@/Components/Admin/ImageModal.vue';
import { router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

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

const modalRechazo = ref(false);
const codigoArechazar = ref(null);
const motivoSeleccionado = ref('');

const abrirRechazo = (id) => {
    codigoArechazar.value = id;
    motivoSeleccionado.value = '';
    modalRechazo.value = true;
};

const confirmarRechazo = () => {
    if (!motivoSeleccionado.value) return;
    router.patch(route('admin.validar', codigoArechazar.value), {
        estado: 'rechazado',
        motivo_descarte: motivoSeleccionado.value,
    }, { preserveScroll: true });
    modalRechazo.value = false;
};

const actualizarEstado = (id, estado) => {
    if (!confirm('¿Estás seguro de que deseas aprobar este código?')) return;
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

const page = usePage();
const toast = ref(null);
let toastTimer = null;

watch(
    () => page.props.flash?.mensaje,
    (msg) => {
        if (!msg) return;
        toast.value = msg;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { toast.value = null; }, 3500);
    }
);
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
                    <strong class="mr-2">{{ item.usuario.nombre }} {{ item.usuario.apellido }}</strong>
                    <small>{{ item.codigo_unico }}</small>
                </div>

                <!-- IMÁGENES -->
                <div class="admin-images">

                    <div class="image-box">
                        <span>Foto del código</span>
                        <img :src="'/storage/' + item.foto_codigo"
                            @click="abrirImagen('/storage/' + item.foto_codigo)" />
                    </div>

                </div>

                <!-- ACCIONES -->
                <div v-if="item.estado === 'pendiente'" class="admin-actions">
                    <button class="btn-approve" @click="actualizarEstado(item.id, 'aprobado')">
                        Aprobar
                    </button>
                    <button class="btn-reject" @click="abrirRechazo(item.id)">
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

        <!-- MODAL IMAGEN -->
        <ImageModal :show="modal" :image="imagenSeleccionada" @close="modal = false" />

        <!-- MODAL RECHAZO -->
        <Teleport to="body">
            <div v-if="modalRechazo" class="rechazo-overlay" @click.self="modalRechazo = false">
                <div class="rechazo-modal">
                    <h3>Motivo de rechazo</h3>
                    <select v-model="motivoSeleccionado" class="rechazo-select">
                        <option value="" disabled>Seleccione el motivo de rechazo</option>
                        <option value="foto">Foto no cumple con parámetros de empaque abierto</option>
                        <option value="codigo_empaque">Código de empaque no coincide con código registrado</option>
                        <option value="mejor_foto">Enviar una mejor foto mostrando empaque abierto y el código legible</option>
                        <option value="caducado">Empaque con codigo de producto caducado</option>
                    </select>
                    <div class="rechazo-actions">
                        <button class="btn-cancelar" @click="modalRechazo = false">Cancelar</button>
                        <button class="btn-confirmar" :disabled="!motivoSeleccionado" @click="confirmarRechazo">Confirmar rechazo</button>
                    </div>
                </div>
            </div>
        </Teleport>

        <!-- TOAST -->
        <Teleport to="body">
            <Transition name="toast">
                <div v-if="toast" class="admin-toast">
                    ✓ {{ toast }}
                </div>
            </Transition>
        </Teleport>

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
    justify-content: center;
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

/* MODAL RECHAZO */
.rechazo-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.rechazo-modal {
    background: white;
    border-radius: 12px;
    padding: 28px;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.rechazo-modal h3 {
    margin: 0 0 18px;
    font-size: 1.1rem;
}

.rechazo-select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9rem;
    outline: none;
    cursor: pointer;
}

.rechazo-select:focus {
    border-color: #111827;
}

.rechazo-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn-cancelar {
    flex: 1;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: white;
    cursor: pointer;
}

.btn-confirmar {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 8px;
    background: #ef4444;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.btn-confirmar:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* TOAST */
.admin-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #111827;
    color: white;
    padding: 14px 22px;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    z-index: 2000;
}

.toast-enter-active,
.toast-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translateY(12px);
}
</style>