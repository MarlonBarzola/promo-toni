<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
import Ranking from '@/Components/Ranking.vue';
import SectionDivider from '@/Components/SectionDivider.vue';
import HeroPromotion from '@/Components/HeroPromotion.vue';
import { useForm, Link } from '@inertiajs/vue3';

defineProps({
    ranking: Array
});

const form = useForm({
    nombre: '',
    apellido: '',
    cedula: '',
    ciudad: '',
    fecha_nacimiento: '',
    email: '',
    acepto_terminos: false,
});

const submit = () => {
    form.post(route('registro.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <LandingLayout dividerBgTop="var(--toni-azul-oscuro)">

        <HeroPromotion>
            <div class="form-card shadow-lg">
                <h2 class="text-center">REGISTRA TUS DATOS</h2>

                <form @submit.prevent="submit" class="mt-4">
                    <div class="mb-2">
                        <input type="text" v-model="form.nombre" placeholder="Nombre:" class="form-input" required>
                    </div>
                    <div class="mb-2">
                        <input type="text" v-model="form.apellido" placeholder="Apellido:" class="form-input" required>
                    </div>
                    <div class="mb-2">
                        <input type="text" v-model="form.cedula" placeholder="Cédula:" class="form-input" required>
                    </div>
                    <div class="mb-2">
                        <input type="text" v-model="form.ciudad" placeholder="Ciudad:" class="form-input" required>
                    </div>
                    <div class="mb-2">
                        <input type="date" v-model="form.fecha_nacimiento" class="form-input" required>
                    </div>
                    <div class="mb-4">
                        <input type="email" v-model="form.email" placeholder="Correo electrónico:" class="form-input"
                            required>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" v-model="form.acepto_terminos"
                            id="checkTerminos" required>
                        <label class="form-check-label text-white small" for="checkTerminos">
                            Acepto Términos y Condiciones
                        </label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-dark-blue text-uppercase w-50" :disabled="form.processing">
                            {{ form.processing ? 'ENVIANDO...' : 'ENVIAR' }}
                        </button>
                    </div>
                </form>
            </div>
        </HeroPromotion>

        <SectionDivider bgTop="var(--toni-azul-marino)" bgBottom="var(--toni-azul-oscuro)" />

        <div class="py-5 ranking-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <Ranking :ranking="ranking" />
                    </div>
                    <div class="col-lg-6">
                        <img src="/images/promo-ranking.png" alt="Promo Ranking Pasión de Hincha Toni"
                            class="img-fluid">
                        <Link :href="route('dashboard')" class="d-block text-center">
                            <button class="btn btn-amarillo-toni btn-ingresa-codigo text-uppercase">
                                Ingresa tu código aquí
                            </button>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
/* Contenedor principal del Hero */
.hero-main {
    position: relative;
    background-color: var(--toni-azul-marino);
    overflow: hidden;
    display: flex;
    align-items: center;
}

/* El fondo de la cancha (Imagen de las líneas) */
.cancha-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('/images/fondo-lineas-estadio.png');
    /* Asegúrate de que el nombre coincida */
    background-size: cover;
    background-position: center;
    opacity: 0.6;
    /* Ajusta la opacidad según prefieras */
    z-index: 1;
}

.z-10 {
    z-index: 10;
}

/* Arte unificado */
.img-promo-main {
    max-width: 100%;
    filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
}

/* Tarjeta de Formulario */
.form-card {
    background-color: #00aeef;
    /* Celeste Toni */
    padding: 40px;
    border-radius: 30px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    margin: 0 auto;
}

.form-title {
    font-family: 'Bebas Neue', sans-serif;
    color: var(--toni-azul-marino);
    font-size: 2.8rem;
    text-align: center;
    margin: 0;
}

/* Inputs minimalistas (Líneas blancas) */
.form-input {
    width: 100%;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    color: white;
    padding: 10px 5px;
    font-weight: bold;
    outline: none;
}

.form-input::placeholder {
    color: rgba(255, 255, 255, 0.8);
}

.form-input:focus {
    border-bottom-color: var(--toni-amarillo);
}

/* Botón de envío */
.btn-enviar-toni {
    background-color: var(--toni-azul-marino);
    color: white;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2rem;
    padding: 10px 60px;
    border-radius: 50px;
    border: none;
    transition: 0.3s;
    box-shadow: 0 5px 0px #00255a;
}

.btn-enviar-toni:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 0px #00255a;
}

.btn-enviar-toni:active {
    transform: translateY(2px);
    box-shadow: 0 2px 0px #00255a;
}

.ranking-section {
    background-color: var(--toni-azul-oscuro);
    padding-bottom: 7rem !important;
}

/* Sección Ranking */
.ranking-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3rem;
    color: var(--toni-amarillo);
}

/* Responsive */
@media (max-width: 991px) {
    .form-card {
        margin-top: 40px;
    }

    .hero-main {
        height: auto;
        padding: 100px 0;
    }
}
</style>