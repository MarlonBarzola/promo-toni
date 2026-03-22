<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const menuAbierto = ref(false);

const isUrlActive = (url) => page.url === url;
const isRouteActive = (routeName) => route().current(routeName);

const toggleMenu = () => {
    menuAbierto.value = !menuAbierto.value;
};
</script>

<template>
    <div>
        <nav class="navbar-custom">
            <div class="container-nav">

                <button class="menu-toggle" @click="toggleMenu" :class="{ 'open': menuAbierto }">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="logo-wrapper-left d-none d-lg-block">
                    <Link :href="route('home')">
                        <img src="/images/logo-pasion.png" alt="Logo Pasión de Hincha" class="logo-pasion">
                    </Link>
                </div>

                <ul class="nav-links" :class="{ 'show': menuAbierto }">
                    <li @click="menuAbierto = false">
                        <Link href="/" :class="{ 'active-link': isUrlActive('/') }">INICIO</Link>
                    </li>
                    <li @click="menuAbierto = false">
                        <Link :href="route('dashboard')" :class="{ 'active-link': isRouteActive('dashboard') }">INGRESAR
                            CÓDIGO</Link>
                    </li>
                    <li @click="menuAbierto = false">
                        <a href="#productos" :class="{ 'active-link': isRouteActive('/#productos') }">PRODUCTOS
                            PARTICIPANTES</a>
                    </li>
                    <li @click="menuAbierto = false">
                        <Link :href="route('terminos')" :class="{ 'active-link': isRouteActive('terminos') }">TÉRMINOS Y
                            CONDICIONES</Link>
                    </li>
                    <li @click="menuAbierto = false">
                        <Link :href="route('faq')" :class="{ 'active-link': isRouteActive('faq') }">PREGUNTAS FRECUENTES
                        </Link>
                    </li>
                </ul>

                <div class="logo-wrapper-right">
                    <img src="/images/logo-toni.svg" alt="Toni Camino al Mundial" class="logo-toni-mundial">
                </div>
            </div>
        </nav>
        <div class="logo-mobile d-md-none">
            <Link :href="route('home')">
                <img src="/images/logo-pasion.png" alt="Logo Pasión de Hincha">
            </Link>
        </div>
    </div>
</template>

<style scoped>
.navbar-custom {
    background-color: var(--toni-azul-cobalto);
    width: 100%;
    top: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    padding-block: 25px;
    height: 80px;
}

.container-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1300px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
}

/* --- BOTÓN HAMBURGUESA --- */
.menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 1005;
}

.menu-toggle span {
    width: 100%;
    height: 3px;
    background-color: white;
    border-radius: 10px;
    transition: all 0.3s linear;
}

/* --- LOGOS --- */
.logo-pasion {
    height: 110px;
    position: absolute;
    top: -20px;
    left: 20px;
    z-index: 1002;
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
}

.logo-toni-mundial {
    height: 120px;
    width: auto;
    background: white;
    padding: 10px;
    position: absolute;
    top: -25px;
    right: 20px;
    z-index: 1001;
}

/* --- LINKS DESKTOP --- */
.nav-links {
    display: flex;
    list-style: none;
    gap: 30px;
    margin: 0 auto;
    padding: 0;
    align-items: center;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-weight: 800;
    font-size: 1rem;
    font-family: var(--fuente-principal);
    transition: 0.3s;
}

.active-link {
    color: var(--toni-amarillo) !important;
}
.logo-mobile img {
    max-width: 25%;
    display: block;
    margin: 0 auto;
}
/* --- MEDIA QUERY: MOBILE --- */
@media (max-width: 991px) {
    .navbar-custom {
        background-color: transparent;
        background-image: url("/images/navbar-background.svg");
        background-size: cover;
        background-position: center;
    }

    .menu-toggle {
        display: flex;
    }

    /* Ajuste de logos en mobile */
    .logo-pasion {
        height: 80px;
        left: 50%;
        transform: translateX(-50%);
        top: -15px;
    }

    .logo-toni-mundial {
        height: 90px;
        top: -30px;
        padding: 5px;
    }

    .logo-wrapper-left,
    .logo-wrapper-right {
        width: 40px;
    }

    /* Menú desplegable */
    .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
        /* Oculto */
        flex-direction: column;
        background-color: var(--toni-azul-marino);
        width: 80%;
        height: 100vh;
        padding: 100px 40px;
        transition: 0.4s ease-in-out;
        z-index: 1004;
        align-items: flex-start;
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
    }

    .nav-links.show {
        left: 0;
    }

    .nav-links li {
        width: 100%;
        margin-bottom: 20px;
    }

    .nav-links a {
        font-size: 1.5rem;
        display: block;
    }

    /* Animación hamburguesa a X */
    .menu-toggle.open span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .menu-toggle.open span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.open span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -8px);
    }
}
</style>