<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import LandingLayout from '@/Layouts/LandingLayout.vue';

defineProps({
    codigos: Object,
    mensaje: String,
});

const vistaActiva = ref(
    new URLSearchParams(window.location.search).get('tab') || 'ingresar'
);

onMounted(() => window.scrollTo(0, 0));

const irAVista = (vista) => {
    vistaActiva.value = vista;
    const url = new URL(window.location);
    url.searchParams.set('tab', vista);
    window.history.pushState({}, '', url);
};

const irAIngresar   = () => irAVista('ingresar');
const irAMisCodigos = () => irAVista('mis-codigos');

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
            vistaActiva.value = 'success';
        },
    });
};

const limpiarFormulario = () => {
    form.reset();
    previewCodigo.value = null;
    previewEmpaque.value = null;
};

const estadoLabel = (estado) =>
    ({ aprobado: 'VERIFICADO', rechazado: 'DESCARTADO' })[estado] ?? 'PENDIENTE';

const formatFecha = (fecha) =>
    new Date(fecha).toLocaleDateString('es-EC', {
        day: '2-digit', month: 'short', year: 'numeric',
    }).toUpperCase();
</script>

<template>
    <Head title="Ingresar Código" />
    <LandingLayout>
        <div class="bg-malla">
            <div class="container">
                <div class="malla-container">
                    <div class="malla-content">
                        <img src="/images/registra-codigo.png" alt="Promoción Toni Camino al Mundial" />    
                    </div>
                    <div class="malla-content">
                        <!-- TABS DESKTOP -->
                        <div class="d-none d-lg-flex tab-nav">
                            <button
                                class="tab-btn"
                                :class="{ 'tab-btn--active': vistaActiva === 'ingresar' || vistaActiva === 'success' }"
                                @click="irAIngresar">
                                INGRESAR CÓDIGOS
                            </button>
                            <button
                                class="tab-btn"
                                :class="{ 'tab-btn--active': vistaActiva === 'mis-codigos' }"
                                @click="irAMisCodigos">
                                MIS CÓDIGOS
                            </button>
                        </div>

                        <div class="tab-content-container" :class="{ 'no-padding': vistaActiva === 'success' }">
                            <!-- INGRESAR -->
                            <div v-if="vistaActiva === 'ingresar'" class="p-4">
                                <h4 class="text-center text-white mb-4">INGRESA TUS CÓDIGOS</h4>

                                <form @submit.prevent="enviarFormulario">
                                    <div class="mb-2">
                                        <input v-model="form.codigo_unico" type="text" class="form-control custom-input"
                                            placeholder="Código único" required>
                                        <div v-if="form.errors.codigo_unico" class="text-danger small mt-1 bg-white rounded px-2">
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

                                    <div class="mb-2 d-flex align-items-center bg-white rounded p-1">
                                        <span class="flex-grow-1 ps-2 small load-image">Foto del código</span>
                                        <label class="btn btn-amarillo-toni btn-sm btn-sm-xs m-0 px-2 text-uppercase">
                                            CARGAR UNA IMAGEN
                                            <input type="file" hidden @change="handleFileChange($event, 'codigo')" accept="image/*"
                                                required>
                                        </label>
                                    </div>

                                    <div class="mb-3 d-flex align-items-center bg-white rounded p-1">
                                        <span class="flex-grow-1 ps-2 small load-image">Foto empaque abierto</span>
                                        <label class="btn btn-amarillo-toni btn-sm btn-sm-xs m-0 px-2 text-uppercase">
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
                                                class="btn btn-dark-blue btn-sm-xs w-100 text-uppercase">
                                                ELIMINAR
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" @click="mostrarModal = true"
                                                class="btn btn-amarillo-toni btn-sm-xs w-100 text-uppercase">
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
                                        <button type="submit" class="btn btn-dark-blue w-50 w-md-25 text-uppercase"
                                            :disabled="form.processing">
                                            {{ form.processing ? 'ENVIANDO...' : 'INGRESAR' }}
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- MIS CÓDIGOS -->
                            <div v-if="vistaActiva === 'mis-codigos'" class="p-4 mis-codigos-content">
                                <h4 class="text-center text-white mb-4">MIS CÓDIGOS REGISTRADOS</h4>

                                <div class="historial-container">
                                    <div v-if="$page.props.loading" class="skeletons">
                                        <div v-for="i in 5" :key="i" class="skeleton-item"></div>
                                    </div>

                                    <template v-else>
                                        <div v-for="item in codigos.data" :key="item.id"
                                            class="codigo-row d-flex justify-content-between align-items-center mb-2 px-3 py-2">
                                            <span class="text-white small">{{ item.codigo_unico }}</span>
                                            <span class="text-white small">{{ formatFecha(item.created_at) }}</span>
                                            <span class="badge-status" :class="item.estado">{{ estadoLabel(item.estado) }}</span>
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

                            <!-- SUCCESS -->
                            <div v-if="vistaActiva === 'success'" class="p-4 text-center success-content">
                                <h4 class="text-white">TU CÓDIGO HA SIDO INGRESADO</h4>
                                <p>REVISAREMOS LA INFORMACIÓN</p>
                                <p>PARA ACEPTAR SU VERACIDAD</p>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <img src="/images/ranking.png" class="img-fluid">
                                    <img src="/images/participa-por-entradas.png" class="img-fluid">
                                </div>
                            </div>

                        </div>

                        <!-- BOTONES -->
                        <div class="text-center mt-4 mb-3 d-flex d-lg-none flex-column align-items-center gap-2">

                            <button v-if="vistaActiva === 'ingresar'" type="button" class="btn btn-primary text-uppercase btn-code"
                                @click="irAMisCodigos">
                                VER MIS CÓDIGOS
                            </button>

                            <button v-else-if="vistaActiva === 'mis-codigos'" type="button" class="btn btn-primary text-uppercase btn-code"
                                @click="irAIngresar">
                                INGRESAR MÁS EMPAQUES
                            </button>

                            <template v-else-if="vistaActiva === 'success'">
                                <button type="button" class="btn btn-primary text-uppercase btn-code" @click="irAIngresar">
                                    INGRESAR OTRO CÓDIGO
                                </button>

                                <button type="button" class="btn btn-primary text-uppercase btn-code" @click="irAMisCodigos">
                                    VER MIS CÓDIGOS
                                </button>
                            </template>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="fade">
            <div v-if="mostrarModal" class="modal-overlay" @click.self="mostrarModal = false">
                <div class="modal-content-custom">
                    <button class="btn-close-custom" @click="mostrarModal = false">X</button>
                    <div class="row align-items-center g-0">
                        <div class="col-6 text-center p-3 rounded-start">
                            <img src="/images/producto.png" class="img-fluid">
                        </div>
                        <div class="col-6 p-3">
                            <h3 class="text-white text-uppercase mb-3 lh-1">
                                Carga una foto clara del código en el envase
                            </h3>
                            <p class="text-white mb-0 lh-1 fw-bold">
                                Necesitamos una foto para verificar la veracidad del código
                            </p>
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
    border-radius: 20px;
    margin-inline: auto;
}

.tab-content-container h4 {
    font-size: 2rem;
}

.custom-input {
    color: var(--toni-celeste);
    border-radius: 10px;
    border: none;
    padding: 10px;
    font-weight: bold;
    font-size: 0.9rem;
}

.custom-input::placeholder {
    color: var(--toni-celeste);
    font-weight: bold;
}

.load-image {
    color: var(--toni-celeste);
    font-weight: bold;
    font-size: 0.9rem;
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
    font-family: var(--fuente-secundaria);
    font-weight: bold;
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

.success-content {
    font-family: var(--fuente-principal);
    font-size: 2rem;
    line-height: 1;
    color: var(--toni-azul-oscuro);
}

.no-padding {
    padding-bottom: 0 !important;
}

.tab-nav {
    gap: 0;
    align-items: flex-end;
}

.tab-btn {
    flex: 1;
    background-color: var(--toni-blanco);
    border: none;
    color: var(--toni-celeste);
    padding: 11px 16px;
    font-family: var(--fuente-principal);
    border-radius: 14px 14px 0 0;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 1.4rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.tab-btn.tab-btn--active {
    background-color: var(--toni-celeste);
    color: white;
    padding-top: 14px;
}

@media (min-width: 992px) {
    .tab-content-container {
        border-radius: 0 0 20px 20px;
    }
}

.mis-codigos-content {
    min-height: 538px;
}

.img-ranking {
    width: 500px;
    margin: 0 auto;
    margin-top: 0px;
    margin-top: -4rem;
}

.btn-code {
    width: 50%;
}

@media (max-width: 991px) {
    .btn-code {
        width: 90%;
    }
    .img-ranking {
        width: 75%;
    }
}

@media (max-width: 430px) {
    .btn-sm-xs {
        font-size: 15px !important;
    }

    .custom-input {
        font-size: 0.6rem;
    }

    .load-image {
        font-size: 0.6rem;
    }
}
</style>