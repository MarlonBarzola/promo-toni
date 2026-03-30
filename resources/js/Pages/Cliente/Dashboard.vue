<script setup>
import { useForm, Link, Head, router } from '@inertiajs/vue3';
import { onMounted, ref, computed } from 'vue';
import LandingLayout from '@/Layouts/LandingLayout.vue';

const props = defineProps({
    codigos: Object,
    mensaje: String,
});

const paginacion = computed(() => {
    const links = props.codigos?.links ?? [];
    return {
        prev:  links.at(0)  ?? null,
        next:  links.at(-1) ?? null,
        pages: links.slice(1, -1),
    };
});

const vistaActiva = ref(
    new URLSearchParams(window.location.search).get('tab') || 'ingresar'
);

onMounted(() => {
    if (!new URLSearchParams(window.location.search).get('page')) {
        window.scrollTo(0, 0);
    }
});

const irAVista = (vista) => {
    vistaActiva.value = vista;
    const url = new URL(window.location);
    url.searchParams.set('tab', vista);
    window.history.pushState({}, '', url);
};

const irAIngresar   = () => irAVista('ingresar');
const irAMisCodigos = () => irAVista('mis-codigos');

const form = useForm({
    codigo_lote: '',
    codigo_conteo: '',
    foto_codigo: null,
});

const previewCodigo = ref(null);
const mostrarModal = ref(false);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    form.foto_codigo = file;
    previewCodigo.value = URL.createObjectURL(file);
};

const enviarFormulario = () => {
    form.post(route('codigo.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            previewCodigo.value = null;
            vistaActiva.value = 'success';
        },
    });
};

const limpiarFormulario = () => {
    form.reset();
    previewCodigo.value = null;
};

const historialRef = ref(null);

const navegarPagina = (url) => {
    const scrollY = window.scrollY;
    router.visit(url + '&tab=mis-codigos', {
        preserveScroll: true,
        onFinish: () => window.scrollTo({ top: scrollY, behavior: 'instant' }),
    });
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

                        <div class="tab-content-container mis-codigos-content">
                            <!-- INGRESAR -->
                            <div v-if="vistaActiva === 'ingresar'" class="p-4">
                                <h4 class="text-center text-white mb-4">INGRESA TUS CÓDIGOS</h4>

                                <form @submit.prevent="enviarFormulario">
                                    <div class="mb-2">
                                        <div class="d-flex gap-2">
                                            <input v-model="form.codigo_lote" type="text"
                                                class="form-control custom-input flex-fill"
                                                placeholder="Código de lote" required>
                                            <input v-model="form.codigo_conteo" type="text"
                                                class="form-control custom-input flex-fill"
                                                placeholder="Código de conteo" required>
                                        </div>
                                        <div v-if="form.errors.codigo_lote" class="text-danger small mt-1 bg-white rounded px-2">
                                            {{ form.errors.codigo_lote }}
                                        </div>
                                        <div v-if="form.errors.codigo_conteo" class="text-danger small mt-1 bg-white rounded px-2">
                                            {{ form.errors.codigo_conteo }}
                                        </div>
                                    </div>

                                    <label class="mb-3 d-flex align-items-center bg-white rounded p-1" style="cursor:pointer">
                                        <span class="flex-grow-1 ps-2 small load-image">Foto del código</span>
                                        <span class="btn btn-amarillo-toni btn-sm btn-sm-xs m-0 px-2 text-uppercase">
                                            CARGAR UNA IMAGEN
                                        </span>
                                        <input type="file" hidden @change="handleFileChange($event)" accept="image/*" required>
                                    </label>

                                    <div class="d-flex gap-2 mb-3 justify-content-center" v-if="previewCodigo">
                                        <img :src="previewCodigo" class="img-thumbnail" width="60">
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
                                            <span class="small">{{ item.codigo_unico }}</span>
                                            <span class="small">{{ formatFecha(item.created_at) }}</span>
                                            <span class="badge-status" :class="item.estado">{{ estadoLabel(item.estado) }}</span>
                                        </div>

                                        <div v-if="codigos.data.length === 0" class="text-center text-white py-4">
                                            <p class="small">Aún no has registrado ningún código.</p>
                                        </div>
                                    </template>
                                </div>

                                <div v-if="codigos.links.length > 3" class="paginacion mt-4">
                                    <button v-if="paginacion.prev?.url"
                                        @click="navegarPagina(paginacion.prev.url)"
                                        class="pag-nav">&#9664;</button>
                                    <span v-else class="pag-nav pag-nav--disabled">&#9664;</span>

                                    <div class="pag-pages">
                                        <template v-for="(link, k) in paginacion.pages" :key="k">
                                            <button v-if="link.url"
                                                @click="navegarPagina(link.url)"
                                                class="pag-num" :class="{ 'pag-num--active': link.active }"
                                                v-html="link.label" />
                                            <span v-else class="pag-dots" v-html="link.label"></span>
                                        </template>
                                    </div>

                                    <button v-if="paginacion.next?.url"
                                        @click="navegarPagina(paginacion.next.url)"
                                        class="pag-nav">&#9654;</button>
                                    <span v-else class="pag-nav pag-nav--disabled">&#9654;</span>
                                </div>
                            </div>

                            <!-- SUCCESS -->
                            <div v-if="vistaActiva === 'success'" class="text-center success-content py-4">
                                <h4 class="text-white">TU CÓDIGO HA SIDO INGRESADO</h4>
                                <p>REVISAREMOS LA INFORMACIÓN</p>
                                <p>PARA ACEPTAR SU VERACIDAD</p>
                                <div class="d-flex mt-3 justify-content-center gap-3 flex-wrap">
                                    <img src="/images/codigo-ingresado.png" class="img-fluid">
                                </div>

                                <div class="text-center mt-4 mb-3 d-flex flex-column align-items-center gap-2">
                                    <button type="button" class="btn btn-primary text-uppercase btn-code" @click="irAIngresar">
                                        INGRESAR OTRO CÓDIGO
                                    </button>

                                    <button type="button" class="btn btn-primary text-uppercase btn-code" @click="irAMisCodigos">
                                        VER MIS CÓDIGOS
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- BOTONES MOBILE -->
                        <div class="text-center mt-4 mb-3 d-flex d-lg-none flex-column align-items-center gap-2">
                            <button v-if="vistaActiva === 'ingresar'" type="button" class="btn btn-primary text-uppercase btn-code"
                                @click="irAMisCodigos">
                                VER MIS CÓDIGOS
                            </button>
                            <button v-else-if="vistaActiva === 'mis-codigos'" type="button" class="btn btn-primary text-uppercase btn-code"
                                @click="irAIngresar">
                                INGRESAR MÁS EMPAQUES
                            </button>
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
    background-color: var(--toni-blanco);
    border-radius: 10px;
    font-size: 0.85rem;
}

.codigo-row span {
    font-weight: bold;
    color: var(--toni-azul-oscuro);
    text-align: center;
}

.badge-status {
    font-weight: bold;
    font-size: 0.75rem;
    min-width: 90px;
    text-align: right;
}

.badge-status.rechazado {
    color: var(--estado-descartado);
}

.paginacion {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.pag-nav {
    color: var(--toni-amarillo);
    font-size: 1rem;
    font-weight: bold;
    text-decoration: none;
    padding: 2px 6px;
    flex-shrink: 0;
    line-height: 1;
    background: none;
    border: none;
    cursor: pointer;
}

.pag-nav--disabled {
    color: rgba(255, 255, 255, 0.25);
    cursor: not-allowed;
}

.pag-pages {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

.pag-num {
    color: white;
    text-decoration: none;
    font-weight: bold;
    font-size: 0.85rem;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
    background: none;
    border: none;
    cursor: pointer;
}

:deep(.pag-num) {
    color: white;
}

.pag-num--active {
    background-color: var(--toni-azul-marino);
}

.pag-dots {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.85rem;
    padding: 0 2px;
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