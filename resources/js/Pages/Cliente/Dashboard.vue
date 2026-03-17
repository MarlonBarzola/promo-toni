<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    codigos: Array,
    mensaje: String
});

const form = useForm({
    codigo_unico: '',
    producto: '',
    foto_codigo: null,
    foto_empaque: null,
});

const previewCodigo = ref(null);
const previewEmpaque = ref(null);

const handleFileChange = (e, tipo) => {
    const file = e.target.files[0];
    if (tipo === 'codigo') {
        form.foto_codigo = file;
        previewCodigo.value = URL.createObjectURL(file);
    } else {
        form.foto_empaque = file;
        previewEmpaque.value = URL.createObjectURL(file);
    }
};

const enviarFormulario = () => {
    form.post(route('codigo.store'), {
        forceFormData: true, // Importante para envío de archivos
        onSuccess: () => {
            form.reset();
            previewCodigo.value = null;
            previewEmpaque.value = null;
        },
    });
};
</script>

<template>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-lg border-0" style="background-color: #0033a0; color: white; border-radius: 15px;">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif;">REGISTRA TU EMPAQUE</h3>
                        
                        <div v-if="$page.props.flash && $page.props.flash.mensaje" class="alert alert-success">
                            {{ $page.props.flash.mensaje }}
                        </div>

                        <form @submit.prevent="enviarFormulario">
                            <div class="mb-3">
                                <label class="form-label">Código Único del Lote</label>
                                <input 
                                    v-model="form.codigo_unico" 
                                    type="text" 
                                    class="form-control" 
                                    :class="{'is-invalid': form.errors.codigo_unico}" 
                                    placeholder="Ej: 37032840..."
                                >
                                <div v-if="form.errors.codigo_unico" class="invalid-feedback fw-bold">
                                    {{ form.errors.codigo_unico }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Producto</label>
                                <select v-model="form.producto" class="form-select" required>
                                    <option value="" disabled>Selecciona un producto</option>
                                    <option value="Yogurt Clásico">Yogurt Clásico</option>
                                    <option value="Gelatoni">Gelatoni</option>
                                    <option value="Avena Toni">Avena Toni</option>
                                    <option value="Choco Taza">Choco Taza</option>
                                </select>
                                <div v-if="form.errors.producto" class="text-warning small mt-1">{{ form.errors.producto }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto clara del código</label>
                                <input type="file" class="form-control" @change="handleFileChange($event, 'codigo')" accept="image/*" required>
                                <div v-if="form.errors.foto_codigo" class="text-warning small mt-1">
                                    {{ form.errors.foto_codigo.replace('foto codigo', 'foto del código') }}
                                </div>
                                <img v-if="previewCodigo" :src="previewCodigo" class="img-thumbnail mt-2" width="100">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Foto del empaque abierto</label>
                                <input type="file" class="form-control" @change="handleFileChange($event, 'empaque')" accept="image/*" required>
                                <div v-if="form.errors.foto_empaque" class="text-warning small mt-1">
                                    {{ form.errors.foto_empaque.replace('foto empaque', 'foto del empaque') }}
                                </div>
                                <img v-if="previewEmpaque" :src="previewEmpaque" class="img-thumbnail mt-2" width="100">
                            </div>

                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2" :disabled="form.processing">
                                {{ form.processing ? 'ENVIANDO...' : 'REGISTRAR CÓDIGO' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <h3 class="mb-4" style="color: #0033a0; font-family: 'Bebas Neue', sans-serif;">MIS CÓDIGOS INGRESADOS</h3>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in codigos" :key="item.id">
                                <td>{{ item.codigo_unico }}</td>
                                <td>{{ item.producto }}</td>
                                <td>{{ new Date(item.created_at).toLocaleDateString() }}</td>
                                <td>
                                    <span :class="{
                                        'badge bg-warning text-dark': item.estado === 'pendiente',
                                        'badge bg-success': item.estado === 'aprobado',
                                        'badge bg-danger': item.estado === 'rechazado'
                                    }">
                                        {{ item.estado.toUpperCase() }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>