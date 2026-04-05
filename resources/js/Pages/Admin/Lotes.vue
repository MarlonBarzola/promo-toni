<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FlashToast from '@/Components/Admin/FlashToast.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    stats:       Object,
    topUsuarios: Array,
});

const page    = usePage();
const mensaje = computed(() => page.props.flash?.mensaje);

const form          = useForm({ csv: null });
const archivoNombre = ref('');
const toastMensaje  = ref('');

const onFileChange = (e) => {
    const file          = e.target.files?.[0] ?? null;
    form.csv            = file;
    archivoNombre.value = file ? file.name : '';
};

const importar = () => {
    form.post(route('admin.lotes.import'), {
        forceFormData: true,
        onSuccess: () => {
            toastMensaje.value  = page.props.flash?.mensaje ?? '¡Importación completada con éxito!';
            form.reset();
            archivoNombre.value = '';
        },
    });
};
</script>

<template>
    <AdminLayout>
        <div class="container py-4">
            <h2 class="mb-4">Lotes de Códigos</h2>

            <FlashToast :mensaje="toastMensaje" />

            <!-- ── Estadísticas ─────────────────────────────── -->
            <div class="row g-3 mb-5">
                <div class="col-sm-4">
                    <div class="stat-card">
                        <div class="stat-value">{{ stats.total.toLocaleString() }}</div>
                        <div class="stat-label">Total en base</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="stat-card stat-card--ok">
                        <div class="stat-value">{{ stats.disponibles.toLocaleString() }}</div>
                        <div class="stat-label">Disponibles</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="stat-card stat-card--used">
                        <div class="stat-value">{{ stats.usados.toLocaleString() }}</div>
                        <div class="stat-label">Canjeados</div>
                    </div>
                </div>
            </div>

            <!-- ── Importar CSV ─────────────────────────────── -->
            <div class="lote-card mb-4">
                <h5 class="text-white mb-1">📥 Importar códigos desde CSV</h5>
                <p class="text-white-50 small mb-4">
                    Formato requerido: dos columnas <code>lote</code> y <code>puntos</code>.<br>
                    Archivos <code>.csv</code> o <code>.txt</code> hasta 20 MB.
                    Los duplicados se omiten automáticamente.
                </p>

                <div class="mb-3">
                    <label class="file-label" :class="{ 'file-label--selected': archivoNombre }">
                        <input type="file" accept=".csv,.txt" class="d-none" @change="onFileChange" />
                        <span v-if="!archivoNombre">📂 Seleccionar archivo CSV</span>
                        <span v-else>✅ {{ archivoNombre }}</span>
                    </label>
                    <div v-if="form.errors.csv" class="text-danger small mt-2">{{ form.errors.csv }}</div>
                </div>

                <button
                    class="btn btn-warning px-4"
                    :disabled="!form.csv || form.processing"
                    @click="importar"
                >
                    <span v-if="form.processing">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>Importando...
                    </span>
                    <span v-else>Importar códigos</span>
                </button>
            </div>

            <!-- ── Formato de ejemplo ───────────────────────── -->
            <div class="lote-card mb-4">
                <h6 class="text-white mb-3">📋 Formato CSV esperado</h6>
                <pre class="example-csv">lote,puntos
L123451,10
L123452,10
L123453,20</pre>
                <p class="text-white-50 small mt-2 mb-0">
                    La primera fila puede ser encabezado (se detecta automáticamente) o datos directamente.
                </p>
            </div>

            <!-- ── Top usuarios ─────────────────────────────── -->
            <div class="lote-card" v-if="topUsuarios.length > 0">
                <h5 class="text-white mb-3">🏆 Ranking por puntos acumulados</h5>
                <table class="table table-dark table-sm mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th class="text-end">Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(u, idx) in topUsuarios" :key="u.usuario">
                            <td class="text-white-50">{{ idx + 1 }}</td>
                            <td>{{ u.usuario }}</td>
                            <td class="text-white-50">{{ u.nombre }} {{ u.apellido }}</td>
                            <td class="text-end fw-bold text-warning">{{ u.puntos_acumulados }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.lote-card {
    background: #1e1e2e;
    border: 1px solid #444;
    border-radius: 10px;
    padding: 24px;
}

.stat-card {
    background: #1e1e2e;
    border: 1px solid #444;
    border-radius: 10px;
    padding: 20px 24px;
    text-align: center;
}

.stat-card--ok   { border-color: #198754; }
.stat-card--used { border-color: #6c757d; }

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #FFD700;
}

.stat-label {
    color: #adb5bd;
    font-size: 0.875rem;
    margin-top: 4px;
}

.file-label {
    display: inline-block;
    cursor: pointer;
    padding: 10px 20px;
    border: 2px dashed #555;
    border-radius: 8px;
    color: #adb5bd;
    transition: border-color 0.2s, color 0.2s;
}

.file-label:hover          { border-color: #FFD700; color: #FFD700; }
.file-label--selected      { border-color: #198754; color: #198754; }

.example-csv {
    background: #111;
    border: 1px solid #333;
    border-radius: 6px;
    padding: 12px 16px;
    color: #a8ff78;
    font-size: 0.85rem;
    margin: 0;
}
</style>
