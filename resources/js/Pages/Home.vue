<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
import Ranking from '@/Components/Ranking.vue';
import HeroPromotion from '@/Components/HeroPromotion.vue';
import PromoBannerRow from '@/Components/Landing/PromoBannerRow.vue';
import { usePage, router, Head } from '@inertiajs/vue3';


defineProps({
    ranking: Array
});

const page = usePage();
const user = page.props.auth?.user;

const logout = () => {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            router.visit('/', { replace: true });
        }
    });
};

const irDashboard = (openLogin) => {
    if (!user) {
        openLogin();
        return;
    }

    window.scrollTo(0, 0);

    router.visit(route('dashboard'), {
        preserveScroll: false,
        preserveState: false,
        onSuccess: () => {
            setTimeout(() => {
                window.scrollTo(0, 0);
            }, 50);
        }
    });
};
</script>

<template>

    <Head title="Inicio" />

    <LandingLayout v-slot="{ activeModal, closeModal, openLogin, openRegister }">

        <HeroPromotion>
            <div class="login">
                <div class="login-buttons">
                    <template v-if="!user">
                        <button @click="openRegister" class="text-uppercase btn-registro">
                            Regístrate
                        </button>
                        <button @click="openLogin" class="text-uppercase btn-login">
                            Iniciar sesión
                        </button>
                    </template>

                    <template v-else>
                        <button @click="$inertia.visit(route('dashboard'))" class="text-uppercase btn-registro">
                            Ingresa un código
                        </button>

                        <button @click="logout" class="text-uppercase btn-login">
                            Cerrar sesión
                        </button>
                    </template>

                </div>
            </div>
        </HeroPromotion>

        <PromoBannerRow class="mb-3" />

        <div class="py-2 ranking-section">
            <div class="container">
                <Ranking :ranking="ranking" />
                <button @click="irDashboard(openLogin)" class="text-uppercase btn btn-ingresar">
                    Ingresa tu código aquí
                </button>
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

.btn-registro:hover {
    color: white;
}

.btn-login {
    background-color: #cee5f2;
    padding: 0 25px;
    transition: 0.3s;
    border-left: 4px solid var(--toni-rojo);
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
}

.btn-login:hover {
    color: var(--toni-rojo);
}

.btn-ingresar {
    background-color: var(--toni-amarillo);
    color: var(--toni-azul-marino);
    border-radius: 12px;
    margin: 20px auto;
    display: block;
    font-size: 1.5rem;
    transform: rotate(-3deg);
    width: 40%;
}

.btn-ingresar:hover {
    color: white;
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

    .btn-ingresar {
        width: 75%;
    }
}
</style>