<script setup>
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    codigos: Array
});

const actualizarEstado = (id, nuevoEstado) => {
    router.patch(route('admin.validar', id), {
        estado: nuevoEstado
    });
};
</script>

<template>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary mb-0">Validación de Códigos "Pasión de Hincha"</h2>
            <button @click="router.post(route('logout'))" class="btn btn-outline-danger">Cerrar sesión</button>
        </div>
        
        <div class="row">
            <div v-for="item in codigos" :key="item.id" class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between">
                        <span>Hincha: {{ item.usuario.nombre }} {{ item.usuario.apellido }}</span>
                        <span class="badge bg-info">{{ item.codigo_unico }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <p class="small mb-1">Foto Código</p>
                                <img :src="'/storage/' + item.foto_codigo" class="img-fluid rounded border" style="height: 150px; object-fit: cover;">
                            </div>
                            <div class="col-6">
                                <p class="small mb-1">Foto Empaque</p>
                                <img :src="'/storage/' + item.foto_empaque" class="img-fluid rounded border" style="height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex gap-2">
                        <button @click="actualizarEstado(item.id, 'aprobado')" class="btn btn-success flex-grow-1">APROBAR</button>
                        <button @click="actualizarEstado(item.id, 'rechazado')" class="btn btn-danger flex-grow-1">RECHAZAR</button>
                    </div>
                </div>
            </div>
            
            <div v-if="codigos.length === 0" class="col-12 text-center py-5">
                <h4 class="text-muted">No hay códigos pendientes por revisar. ¡Buen trabajo!</h4>
            </div>
        </div>
    </div>
</template>