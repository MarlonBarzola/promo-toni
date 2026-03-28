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

        <div class="d-block d-md-none pl-3">
            <img src="/images/banner-promo-mobile.png" alt="">
        </div>

        <div class="container">
            <div class="ranking">
                <div class="ranking-section">
                    <Ranking :ranking="ranking" />
                     <button @click="irDashboard(openLogin)" class="text-uppercase btn btn-ingresar d-block d-md-none">
                        Ingresa tu código aquí
                    </button>
                </div>
                <div class="promo-section d-none d-md-block">
                    <PromoBannerRow />
                    <button @click="irDashboard(openLogin)" class="text-uppercase btn btn-ingresar d-none d-md-block">
                        Ingresa tu código aquí
                    </button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="banner-semanal">
                <img src="/images/banner-semanal.png" alt="Gana premios semanales">
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
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
    margin-top: -2rem;
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
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.btn-registro:hover {
    color: white;
}

.btn-login {
    background-color: #cee5f2;
    padding: 0 25px;
    transition: 0.3s;
    border-left: 4px solid var(--toni-rojo);
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.btn-login:hover {
    color: var(--toni-rojo);
}

.btn-ingresar {
    background-color: var(--toni-amarillo);
    border-radius: 12px;
    color: var(--toni-azul-marino);
    display: block;
    font-size: 1.5rem;
    margin: 20px auto;
    margin-top: -4rem;
    transform: rotate(3deg);
    width: auto;
}

.btn-ingresar:hover {
    color: white;
}

.banner-semanal {
    width: calc(50% + 50vw);
    overflow: hidden;
}

.banner-semanal img {
    width: 100%;
    display: block;
}

.ranking {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.ranking-section {
    width: 48%;
}

.promo-section {
    width: 50%;
}

@media (max-width: 991px) {
    .form-card {
        margin-top: 40px;
    }

    .btn-ingresar {
        margin-top: 1rem;
        transform: none;
    }

    .promo-section {
        padding-right: 0 !important;
    }

    .login {
        align-items: center;
        background-image: url("/images/bg-cancha.svg");
        background-position: center top;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        height: 50vw;
        justify-content: center;
        margin-top: -15.5vw;
        width: 100%;
    }

    .login-buttons button {
        font-size: 1.2rem;
    }

    .ranking {
        flex-direction: column-reverse;
    }

    .ranking-section {
        width: 100%;
    }

    .promo-section {
        width: 100%;
    }
}
</style>