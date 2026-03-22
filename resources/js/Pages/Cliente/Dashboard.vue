<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import LandingLayout from '@/Layouts/LandingLayout.vue';
import HeroPromotion from '@/Components/HeroPromotion.vue';

const props = defineProps({
    codigos: Object,
    mensaje: String
});

const urlParams = new URLSearchParams(window.location.search);
const tabActiva = ref(urlParams.get('tab') || 'ingresar');

const cambiarTab = (tab) => {
    tabActiva.value = tab;
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.pushState({}, '', url);
};

const form = useForm({
    codigo_unico: '',
    producto: '',
    foto_codigo: null,
    foto_empaque: null,
});

const previewCodigo = ref(null);
const previewEmpaque = ref(null);
const mostrarModal = ref(false);

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
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            previewCodigo.value = null;
            previewEmpaque.value = null;
        },
    });
};

const limpiarFormulario = () => {
    form.reset();
    previewCodigo.value = null;
    previewEmpaque.value = null;
};

const abrirModalReferencia = () => {
    mostrarModal.value = true;
};

const cerrarModal = () => {
    mostrarModal.value = false;
};
</script>

<template>
    <LandingLayout>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img src="/images/registra-codigo.png" alt="Promoción Toni Camino al Mundial" class="img-fluid my-4">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="d-flex mb-0">
                <button @click="cambiarTab('ingresar')" class="btn-tab left"
                    :class="{ 'active': tabActiva === 'ingresar' }">
                    INGRESAR CÓDIGOS
                </button>
                <button @click="cambiarTab('mis-codigos')" class="btn-tab right"
                    :class="{ 'active': tabActiva === 'mis-codigos' }">
                    MIS CÓDIGOS
                </button>
            </div>
            <div class="tab-content-container shadow-lg">

                <div v-if="tabActiva === 'ingresar'" class="p-4">
                    <h4 class="text-center text-white mb-4 fw-bold">INGRESA TUS CÓDIGOS</h4>

                    <form @submit.prevent="enviarFormulario">
                        <div class="mb-2">
                            <input v-model="form.codigo_unico" type="text" class="form-control custom-input"
                                placeholder="Código único" required>
                            <div v-if="form.errors.codigo_unico"
                                class="text-danger small fw-bold mt-1 bg-white rounded px-2">
                                {{ form.errors.codigo_unico }}
                            </div>
                        </div>

                        <div class="mb-2">
                            <select v-model="form.producto" class="form-select custom-input" required>
                                <option value="" disabled selected>Producto participante</option>
                                <option value="Yogurt Clásico">Yogurt Clásico</option>
                                <option value="Gelatoni">Gelatoni</option>
                                <option value="Avena Toni">Avena Toni</option>
                            </select>
                        </div>

                        <div class="mb-2 d-flex align-items-center bg-white rounded p-1 shadow-sm">
                            <span class="flex-grow-1 ps-2 text-primary small">Foto del código</span>
                            <label class="btn btn-amarillo-toni btn-sm m-0 px-2 text-uppercase">
                                CARGAR UNA IMAGEN
                                <input type="file" hidden @change="handleFileChange($event, 'codigo')" accept="image/*"
                                    required>
                            </label>
                        </div>

                        <div class="mb-3 d-flex align-items-center bg-white rounded p-1 shadow-sm">
                            <span class="flex-grow-1 ps-2 text-primary small">Foto empaque
                                abierto</span>
                            <label class="btn btn-amarillo-toni btn-sm m-0 px-2 text-uppercase">
                                CARGAR UNA IMAGEN
                                <input type="file" hidden @change="handleFileChange($event, 'empaque')" accept="image/*"
                                    required>
                            </label>
                        </div>

                        <div class="d-flex gap-2 mb-3 justify-content-center" v-if="previewCodigo || previewEmpaque">
                            <img v-if="previewCodigo" :src="previewCodigo" class="img-thumbnail" width="60">
                            <img v-if="previewEmpaque" :src="previewEmpaque" class="img-thumbnail" width="60">
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <button type="button" @click="limpiarFormulario"
                                    class="btn btn-dark-blue w-100 text-uppercase py-2">
                                    ELIMINAR
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" @click="abrirModalReferencia"
                                    class="btn btn-amarillo-toni w-100 text-uppercase py-2">
                                    IMAGEN DE REFERENCIA
                                </button>
                            </div>
                        </div>

                        <div class="important-box mb-4">
                            <p class="mb-0 fw-bold">IMPORTANTE:</p>
                            <p class="mb-0">Carga una foto clara del código en el envase.</p>
                            <p class="mb-0">Necesitamos una foto para verificar la veracidad del código</p>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-dark-blue px-5 py-2 fw-bold text-uppercase shadow"
                                :disabled="form.processing">
                                {{ form.processing ? 'ENVIANDO...' : 'INGRESAR' }}
                            </button>
                        </div>
                    </form>
                </div>

                <div v-if="tabActiva === 'mis-codigos'" class="p-4">
                    <h4 class="text-center text-white mb-4 fw-bold">MIS CÓDIGOS REGISTRADOS</h4>

                    <div class="historial-container">
                        <div v-if="$page.props.loading" class="skeletons">
                            <div v-for="i in 5" :key="i" class="skeleton-item"></div>
                        </div>

                        <template v-else>
                            <div v-for="item in codigos.data" :key="item.id"
                                class="codigo-row d-flex justify-content-between align-items-center mb-2 px-3 py-2">
                                <span class="text-white fw-bold small">{{ item.codigo_unico }}</span>
                                <span class="text-white small">
                                    {{ new Date(item.created_at).toLocaleDateString('es-EC', {
                                        day: '2-digit', month: 'short', year: 'numeric'
                                    }).toUpperCase() }}
                                </span>
                                <span class="badge-status" :class="item.estado">
                                    {{ item.estado === 'aprobado' ? 'VERIFICADO' : (item.estado === 'rechazado'
                                        ? 'DESCARTADO' : 'PENDIENTE') }}
                                </span>
                            </div>

                            <div v-if="codigos.data.length === 0" class="text-center text-white py-4">
                                <p class="small">Aún no has registrado ningún código.</p>
                            </div>
                        </template>
                    </div>

                    <div v-if="codigos.links.length > 3"
                        class="d-flex justify-content-center align-items-center mt-4 gap-2">
                        <template v-for="(link, k) in codigos.links" :key="k">
                            <Link v-if="link.url" :href="link.url + '&tab=mis-codigos'" class="page-link-custom"
                                :class="{ 'active': link.active }" v-html="link.label" preserve-scroll />
                            <span v-else class="page-link-disabled" v-html="link.label"></span>
                        </template>
                    </div>
                </div>

            </div>
        </div>
        <Transition name="fade">
            <div v-if="mostrarModal" class="modal-overlay" @click.self="cerrarModal">
                <div class="modal-content-custom">
                    <button class="btn-close-custom" @click="cerrarModal">X</button>
                    <div class="row align-items-center g-0">
                        <div class="col-md-6 text-center bg-white p-4 rounded-start">
                            <img src="/img/ejemplo-codigo.png" alt="Ejemplo Código" class="img-fluid">
                        </div>
                        <div class="col-md-6 p-4">
                            <h3 class="fw-bold text-white text-uppercase mb-3">Carga una foto clara del código en el
                                envase
                            </h3>
                            <p class="text-white mb-0">Necesitamos una foto para verificar la veracidad del código</p>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </LandingLayout>
</template>

<style scoped>
.tab-content-container {
    background-color: var(--toni-celeste);
    border-radius: 0 0 20px 20px;
    min-height: 450px;
}

.btn-tab {
    flex: 1;
    border: none;
    padding: 12px;
    font-weight: bold;
    font-size: 0.9rem;
    background-color: var(--toni-celeste);
    color: white;
    transition: 0.3s;
}

.btn-tab.left {
    border-radius: 20px 20px 0 0;
    margin-right: 2px;
}

.btn-tab.right {
    border-radius: 20px 20px 0 0;
}

.btn-tab.active {
    background-color: white;
    color: var(--toni-celeste);
}

.custom-input {
    border-radius: 10px;
    border: none;
    padding: 10px;
}

.bg-info-light {
    background-color: var(--toni-blanco-transp);
}

.codigo-row {
    background-color: var(--toni-blanco-transp);
    border-radius: 10px;
    font-size: 0.85rem;
}

.badge-status {
    font-weight: bold;
    font-size: 0.75rem;
    min-width: 90px;
    text-align: right;
}

.badge-status.pendiente {
    color: var(--estado-pendiente);
}

.badge-status.aprobado {
    color: var(--estado-verificado);
}

.badge-status.rechazado {
    color: var(--estado-descartado);
}

.page-num {
    color: white;
    font-weight: bold;
}

.page-num.active {
    background-color: var(--toni-azul-marino);
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.text-yellow {
    color: var(--toni-amarillo) !important;
}

.btn-pag {
    background: none;
    border: none;
}

.page-link-custom {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 2px 8px;
    transition: 0.3s;
    font-size: 0.9rem;
}

.page-link-custom.active {
    background-color: var(--toni-azul-marino);
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-link-disabled {
    color: rgba(255, 255, 255, 0.4);
    cursor: not-allowed;
    padding: 2px 8px;
    font-size: 0.9rem;
}

:deep(.page-link-custom) {
    color: white;
}

.page-link-custom:first-child,
.page-link-custom:last-child {
    color: var(--toni-amarillo);
    font-size: 1.2rem;
}

.important-box {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 15px;
    color: white;
    text-align: center;
    font-size: 0.75rem;
    line-height: 1.2;
}

.custom-input::placeholder {
    color: var(--toni-celeste);
    font-weight: 500;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 51, 160, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content-custom {
    background-color: var(--toni-celeste);
    width: 90%;
    max-width: 800px;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    border: 3px solid white;
}

.btn-close-custom {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    color: white;
    font-weight: bold;
    font-size: 1.5rem;
    z-index: 10;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.modal-content-custom h3 {
    font-family: var(--fuente-principal);
    font-size: 1.8rem;
    line-height: 1.1;
}
</style>