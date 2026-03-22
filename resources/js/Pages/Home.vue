<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
import Ranking from '@/Components/Ranking.vue';
import SectionDivider from '@/Components/SectionDivider.vue';
import HeroPromotion from '@/Components/HeroPromotion.vue';
import RegistrationForm from '@/Components/Landing/RegistrationForm.vue';
import LoginForm from '@/Components/Landing/LoginForm.vue';
import PromoBannerRow from '@/Components/Landing/PromoBannerRow.vue';
import AuthModal from '@/Components/Common/AuthModal.vue';
import { ref } from 'vue';

defineProps({
    ranking: Array
});

const activeModal = ref(null); // 'register', 'login' o null

const closeModal = () => activeModal.value = null;
</script>

<template>
    <LandingLayout dividerBgTop="var(--toni-azul-oscuro)">

        <HeroPromotion>
            <RegistrationForm class="d-none d-md-block" />
        </HeroPromotion>

        <div class="login">
            <div class="login-buttons">
                <button @click="activeModal = 'register'" class="text-uppercase btn-registro">
                    Regístrate
                </button>
                <button @click="activeModal = 'login'" class="text-uppercase btn-login">
                    Iniciar sesión
                </button>
            </div>
        </div>

        <AuthModal :show="activeModal !== null" @close="closeModal">
            <div v-if="activeModal === 'register'">
                <RegistrationForm @success="closeModal" />
            </div>

            <div v-if="activeModal === 'login'">
                <LoginForm @success="closeModal" />
            </div>
        </AuthModal>

        <PromoBannerRow />

        <!--  <SectionDivider bgTop="var(--toni-azul-marino)" bgBottom="var(--toni-azul-oscuro)" /> -->

        <div class="py-2 ranking-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <Ranking :ranking="ranking" />
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
    background-color: var(--toni-azul-marino);
}

/* Sección Ranking */
.ranking-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3rem;
    color: var(--toni-amarillo);
}

.login {
    background-color: var(--toni-azul-marino);
    background-image: url("/images/bg-malla.svg");
    background-size: cover;
    background-position: center;
}

.login-buttons {
    display: flex;
    justify-content: center;
    padding-block: 3rem;
}

.login-buttons button {
    color: var(--toni-azul-oscuro);
    font-family: var(--fuente-principal);
    font-size: 1.5rem;
}

.btn-registro {
    background-color: var(--toni-amarillo);
    padding: 0 25px;
    transition: 0.3s;
    border-right: 4px solid var(--toni-rojo);
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
}


.btn-login {
    background-color: #cee5f2;
    padding: 0 25px;
    transition: 0.3s;
    border-left: 4px solid var(--toni-rojo);
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
}

/* Responsive */
@media (max-width: 991px) {
    .form-card {
        margin-top: 40px;
    }

    .hero-main {
        height: auto;
        padding: 0;
    }
}
</style>