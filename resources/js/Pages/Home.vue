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

    router.visit(route('dashboard'), {
        preserveScroll: false,
        preserveState: false,
        onSuccess: () => {
            setTimeout(() => window.scrollTo(0, 0), 50);
        }
    });
};
</script>

<template>

    <Head title="Inicio" />

    <LandingLayout v-slot="{ openLogin, openRegister }">

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

        <div class="d-block d-lg-none pl-3">
            <img src="/images/banner-promo-mobile.png" alt="" loading="lazy">
        </div>

        <div class="container">
            <div class="ranking">
                <div class="ranking-section">
                    <Ranking :ranking="ranking" />
                     <button @click="irDashboard(openLogin)" class="text-uppercase btn btn-ingresar d-block d-lg-none">
                        Ingresa tu código aquí
                    </button>
                </div>
                <div class="promo-section d-none d-lg-block">
                    <PromoBannerRow />
                    <button @click="irDashboard(openLogin)" class="text-uppercase btn btn-ingresar d-none d-lg-block">
                        Ingresa tu código aquí
                    </button>
                </div>
            </div>
        </div>
        <div class="container d-none d-lg-block">
            <div class="banner-semanal">
                <img src="/images/banner-semanal.png" alt="Gana premios semanales">
            </div>
        </div>
       
        <img src="/images/premios-mobile.png" alt="Gana premios semanales" class="d-block d-lg-none">
    </LandingLayout>
</template>

<style scoped>
/* ── Layout ─────────────────────────────────────────────── */
.ranking {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    position: relative;
}

.ranking-section {
    width: 48%;
    background-color: var(--toni-azul-marino);
}

.promo-section {
    width: 50%;
}

/* ── Sección login / cancha ──────────────────────────────── */
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

/* ── Botones ─────────────────────────────────────────────── */
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
    color: var(--toni-azul-marino);
    border-radius: 12px;
    display: block;
    font-size: 1.5rem;
    margin: -4rem auto 20px;
    transform: rotate(3deg);
    width: auto;
}

.btn-ingresar:hover {
    color: white;
}

/* ── Banner semanal ──────────────────────────────────────── */
.banner-semanal {
    width: calc(50% + 50vw);
    overflow: hidden;
}

.banner-semanal img {
    width: 100%;
    display: block;
}

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 991px) {
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

    .ranking-section,
    .promo-section {
        width: 100%;
    }

    .btn-ingresar {
        margin-top: 1rem;
        transform: none;
    }
}
</style>