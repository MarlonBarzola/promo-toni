<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import { onMounted, ref, computed } from 'vue';
import LandingLayout from '@/Layouts/LandingLayout.vue';
import ModalRechazo from '@/Components/Cliente/ModalRechazo.vue';
import ModalReferencia from '@/Components/Cliente/ModalReferencia.vue';
import Paginacion from '@/Components/Common/Paginacion.vue';

const props = defineProps({
    codigos: Object,
    mensaje: String,
    ranking: Object,
});

const paginacion = computed(() => {
    const links = props.codigos?.links ?? [];
    return {
        prev: links.at(0) ?? null,
        next: links.at(-1) ?? null,
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

const irAIngresar = () => irAVista('ingresar');
const irAMisCodigos = () => irAVista('mis-codigos');

const form = useForm({
    codigo_lote: '',
    codigo_conteo: '',
    foto_codigo: null,
});

const previewCodigo = ref(null);
const mostrarModal = ref(false);
const fileInputKey = ref(0);

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
    fileInputKey.value++;
};

const mostrarModalRechazo = ref(false);
const motivoRechazo = ref(null);

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
                    <div class="img-malla">
                        <img src="/images/registra-codigo.png" alt="Promoción Toni Camino al Mundial" />
                    </div>
                    <div class="malla-content">
                        <!-- TABS DESKTOP -->
                        <div class="d-none d-lg-flex tab-nav">
                            <button class="tab-btn"
                                :class="{ 'tab-btn--active': vistaActiva === 'ingresar' || vistaActiva === 'success' }"
                                @click="irAIngresar">
                                INGRESAR CÓDIGOS
                            </button>
                            <button class="tab-btn" :class="{ 'tab-btn--active': vistaActiva === 'mis-codigos' }"
                                @click="irAMisCodigos">
                                MIS CÓDIGOS
                            </button>
                        </div>

                        <div class="tab-content-container mis-codigos-content">
                            <!-- INGRESAR -->
                            <div v-if="vistaActiva === 'ingresar'" class="p-4">
                                <h4 class="text-center text-dark-blue mb-4">INGRESA TUS CÓDIGOS</h4>

                                <form @submit.prevent="enviarFormulario">
                                    <div class="mb-2">
                                        <div class="d-flex gap-2">
                                            <input v-model="form.codigo_lote" type="text"
                                                class="form-control custom-input flex-fill" placeholder="Código de lote"
                                                required>
                                            <input v-model="form.codigo_conteo" type="text"
                                                class="form-control custom-input flex-fill"
                                                placeholder="Código de conteo" required>
                                        </div>
                                        <div v-if="form.errors.codigo_lote"
                                            class="text-danger small mt-1 bg-white rounded px-2">
                                            {{ form.errors.codigo_lote }}
                                        </div>
                                        <div v-if="form.errors.codigo_conteo"
                                            class="text-danger small mt-1 bg-white rounded px-2">
                                            {{ form.errors.codigo_conteo }}
                                        </div>
                                    </div>

                                    <label class="mb-3 d-flex align-items-center bg-white rounded p-1"
                                        style="cursor:pointer">
                                        <span class="flex-grow-1 ps-2 small load-image">Foto del código</span>
                                        <span class="btn btn-amarillo-toni btn-sm btn-sm-xs m-0 px-2 text-uppercase">
                                            CARGAR UNA IMAGEN
                                        </span>
                                        <input :key="fileInputKey" type="file" hidden @change="handleFileChange($event)" accept="image/*"
                                            required>
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

                                <!-- Ranking del usuario -->
                                <div class="ranking-row mb-4">
                                    <div class="ranking-headers d-flex justify-content-between px-3 mb-2">
                                        <span>NOMBRE DE USUARIO</span>
                                        <span>PUNTOS ACUMULADOS</span>
                                        <span>PUESTO EN EL RANKING</span>
                                    </div>
                                    <div class="codigo-row d-flex justify-content-between align-items-center px-3 py-2">
                                        <span>{{ ranking.usuario }}</span>
                                        <span class="ranking-puntos">{{ ranking.puntos }}</span>
                                        <span class="ranking-puesto">
                                            {{ ranking.puesto ? `#${ranking.puesto}` : '#000' }}
                                        </span>
                                    </div>
                                </div>

                                <h4 class="text-center text-dark-blue mb-4">MIS CÓDIGOS REGISTRADOS</h4>

                                <div class="historial-container">
                                    <div v-if="$page.props.loading" class="skeletons">
                                        <div v-for="i in 5" :key="i" class="skeleton-item"></div>
                                    </div>

                                    <template v-else>
                                        <div v-for="item in codigos.data" :key="item.id"
                                            class="codigo-row d-flex justify-content-between align-items-center mb-2 px-3 py-2">
                                            <span class="small">{{ item.codigo_unico }}</span>
                                            <span class="small">{{ formatFecha(item.created_at) }}</span>
                                            <span class="badge-status" :class="item.estado">{{ estadoLabel(item.estado)
                                                }}</span>
                                            <button v-if="item.estado === 'rechazado'" class="btn-motivo"
                                                @click="mostrarModalRechazo = true; motivoRechazo = item.motivo_descarte"
                                                title="Ver motivo">
                                                <img src="/images/icon-buzon.svg" alt="Motivo de rechazo">
                                            </button>
                                        </div>

                                        <div v-if="codigos.data.length === 0" class="text-center text-white py-4">
                                            <p class="small">Aún no has registrado ningún código.</p>
                                        </div>
                                    </template>
                                </div>

                                <Paginacion :paginacion="paginacion" :links="codigos.links" />
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
                                    <button type="button" class="btn btn-primary text-uppercase btn-code"
                                        @click="irAIngresar">
                                        INGRESAR OTRO CÓDIGO
                                    </button>

                                    <button type="button" class="btn btn-primary text-uppercase btn-code"
                                        @click="irAMisCodigos">
                                        VER MIS CÓDIGOS
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- BOTONES MOBILE -->
                        <div class="text-center mt-4 mb-3 d-flex d-lg-none flex-column align-items-center gap-2">
                            <button v-if="vistaActiva === 'ingresar'" type="button"
                                class="btn btn-primary text-uppercase btn-code" @click="irAMisCodigos">
                                VER MIS CÓDIGOS
                            </button>
                            <button v-else-if="vistaActiva === 'mis-codigos'" type="button"
                                class="btn btn-primary text-uppercase btn-code" @click="irAIngresar">
                                INGRESAR MÁS EMPAQUES
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Transition name="fade">
            <ModalRechazo v-if="mostrarModalRechazo" :motivo="motivoRechazo" @close="mostrarModalRechazo = false" />
        </Transition>

        <Transition name="fade">
            <ModalReferencia v-if="mostrarModal" @close="mostrarModal = false" />
        </Transition>
    </LandingLayout>
</template>

<style scoped>
/* ─── Layout ─────────────────────────────────────────────────── */
.tab-content-container {
    background-color: var(--toni-celeste);
    border-radius: 20px;
    margin-inline: auto;
}

.tab-content-container h4 {
    font-size: 2rem;
}

.mis-codigos-content {
    min-height: 538px;
}

.ranking-headers {
    color: var(--toni-blanco);
    font-size: 0.8em;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
    line-height: 1;
}

.ranking-puntos, .ranking-puesto {
    font-size: 1.3rem;
}

/* ─── Tabs desktop ────────────────────────────────────────────── */
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
}

/* ─── Formulario ──────────────────────────────────────────────── */
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

/* ─── Lista de códigos ────────────────────────────────────────── */
.codigo-row {
    background-color: var(--toni-blanco);
    border-radius: 10px;
    font-size: 0.85rem;
    position: relative;
}

.codigo-row span {
    font-weight: bold;
    color: var(--toni-azul-oscuro);
    text-align: center;
}

.ranking-puesto {
    min-width: 90px;
    text-align: right;
}

.badge-status {
    font-weight: bold;
    font-size: 0.75rem;
    width: 110px;
    text-align: right;
}

.badge-status.rechazado {
    background-color: var(--toni-amarillo);
}

.btn-motivo {
    background-color: var(--toni-amarillo);
    border-radius: 100%;
    border: none;
    cursor: pointer;
    color: var(--toni-azul-oscuro);
    flex-shrink: 0;
    position: absolute;
    right: -45px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-motivo img {
    width: 20px;
}

/* ─── Vista success ───────────────────────────────────────────── */
.success-content {
    font-family: var(--fuente-principal);
    font-size: 2rem;
    line-height: 1;
    color: var(--toni-azul-oscuro);
}

/* ─── Botones navegación ──────────────────────────────────────── */
.btn-code {
    width: 50%;
}

/* ─── Transiciones ────────────────────────────────────────────── */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* ─── Responsive ──────────────────────────────────────────────── */
@media (min-width: 992px) {
    .tab-content-container {
        border-radius: 0 0 20px 20px;
    }
}

@media (max-width: 992px) {
    .btn-code {
        width: 90%;
    }

    .btn-motivo {
        right: -40px;
    }
    .img-malla {
        margin-bottom: -2.4rem;
        position: relative;
    }
}

@media (max-width: 430px) {
    .btn-sm-xs {
        font-size: 15px !important;
    }

    .custom-input,
    .load-image {
        font-size: 0.6rem;
    }
}
</style>