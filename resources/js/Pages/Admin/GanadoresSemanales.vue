<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    ganadores: Array,
    semanaActual: Number,
    anioActual: Number,
    totalActivos: Number,
});

const page = usePage();
const mensaje = computed(() => page.props.flash?.mensaje);

const form = useForm({
    archivo: null,
});

const archivoNombre = ref('');

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.archivo = file;
        archivoNombre.value = file.name;
    }
};

const submit = () => {
    form.post(route('admin.ganadores.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset('archivo');
            archivoNombre.value = '';
        },
    });
};
</script>

<template>
    <AdminLayout>
        <div class="ganadores-admin">
            <div class="page-header">
                <h2>🏆 Ganadores Semanales</h2>
                <span class="semana-badge">Semana {{ semanaActual }} · {{ anioActual }}</span>
            </div>

            <!-- Flash -->
            <div v-if="mensaje" class="alert-success">
                {{ mensaje }}
            </div>

            <!-- Upload Card -->
            <div class="card mb-4">
                <h3 class="card-title">Cargar archivo CSV</h3>
                <p class="card-hint">
                    El archivo debe contener una cédula por fila. Los registros se asignarán a la semana actual
                    (Semana {{ semanaActual }}). Si se sube en una semana nueva, los registros anteriores quedarán
                    deshabilitados automáticamente.
                </p>

                <form @submit.prevent="submit" class="upload-form">
                    <label class="file-label">
                        <input type="file" accept=".csv,.txt" @change="onFileChange" class="file-input" />
                        <span class="file-btn">📂 Seleccionar CSV</span>
                        <span class="file-name">{{ archivoNombre || 'Ningún archivo seleccionado' }}</span>
                    </label>

                    <div v-if="form.errors.archivo" class="error-msg">{{ form.errors.archivo }}</div>

                    <button type="submit" class="btn-upload" :disabled="form.processing || !form.archivo">
                        {{ form.processing ? 'Cargando...' : 'Subir ganadores' }}
                    </button>
                </form>
            </div>

            <!-- Tabla de ganadores activos -->
            <div class="card">
                <h3 class="card-title">
                    Ganadores activos
                    <span class="count-badge">{{ totalActivos }}</span>
                </h3>

                <div v-if="ganadores.length === 0" class="empty-state">
                    No hay ganadores cargados para la semana actual.
                </div>

                <table v-else class="ganadores-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cédula</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(g, i) in ganadores" :key="g.id">
                            <td>{{ i + 1 }}</td>
                            <td>{{ g.cedula }}</td>
                            <td>{{ g.usuario ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.ganadores-admin {
    padding: 24px;
}

.page-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}

.page-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.semana-badge {
    background: #3b82f6;
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 999px;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 20px;
    font-weight: 600;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

.card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-hint {
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 20px;
}

.upload-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.file-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
}

.file-input {
    display: none;
}

.file-btn {
    background: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 0.9rem;
    cursor: pointer;
    white-space: nowrap;
}

.file-btn:hover {
    background: #e5e7eb;
}

.file-name {
    font-size: 0.85rem;
    color: #6b7280;
}

.error-msg {
    color: #dc2626;
    font-size: 0.82rem;
}

.btn-upload {
    align-self: flex-start;
    background: #1d4ed8;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-upload:hover:not(:disabled) {
    background: #1e40af;
}

.btn-upload:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.count-badge {
    background: #e5e7eb;
    color: #374151;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 999px;
}

.empty-state {
    text-align: center;
    padding: 40px 0;
    color: #9ca3af;
    font-size: 0.9rem;
}

.ganadores-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.ganadores-table th {
    background: #f9fafb;
    text-align: left;
    padding: 10px 14px;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.ganadores-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #f3f4f6;
    color: #1f2937;
}

.ganadores-table tr:last-child td {
    border-bottom: none;
}
</style>
