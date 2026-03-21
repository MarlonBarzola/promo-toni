<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

// Comprobar si la ruta actual coincide con el nombre de la ruta o la URL
const isUrlActive = (url) => page.url === url;
const isRouteActive = (routeName) => route().current(routeName);
</script>

<template>
    <nav class="navbar-custom">
        <div class="container-nav">
            <div class="logo-wrapper-left">
                <Link :href="route('home')">
                    <img src="/images/logo-pasion.png" alt="Logo Pasión de Hincha" class="logo-pasion">
                </Link>
            </div>

            <ul class="nav-links">
                <li>
                    <Link href="/" :class="{ 'active-link': isUrlActive('/') }">
                        INICIO
                    </Link>
                </li>
                <li>
                    <Link :href="route('dashboard')" :class="{ 'active-link': isRouteActive('dashboard') }">
                        INGRESAR CÓDIGO
                    </Link>
                </li>
                <li>
                    <a href="#productos" :class="{ 'active-link': isRouteActive('/#productos') }">
                        PRODUCTOS PARTICIPANTES
                    </a>
                </li>
                <li>
                    <Link :href="route('terminos')" :class="{ 'active-link': isRouteActive('terminos') }">
                        TÉRMINOS Y CONDICIONES
                    </Link>
                </li>
                <li>
                    <Link :href="route('faq')" :class="{ 'active-link': isRouteActive('faq') }">
                        PREGUNTAS FRECUENTES
                    </Link>
                </li>
            </ul>

            <div class="logo-wrapper-right">
                <img src="/images/logo-toni.svg" alt="Toni Camino al Mundial" class="logo-toni-mundial">
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar-custom {
    background-color: var(--toni-azul-cobalto);
    width: 100%;
    position: relative;
    z-index: 1000;
    display: flex;
    align-items: center;
    padding-block: 35px;
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

/* --- LOGOS POSICIONADOS --- */

.logo-wrapper-left {
    width: 180px;
    /* Espacio reservado para que no pise el menú */
}

.logo-pasion {
    height: 110px;
    position: absolute;
    top: -27px;
    left: 20px;
    z-index: 1002;
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    transition: transform 0.3s ease;
}

.logo-pasion:hover {
    transform: scale(1.05);
}

.logo-wrapper-right {
    width: 120px;
    /* Espacio reservado a la derecha */
}

.logo-toni-mundial {
    height: 135px;
    width: auto;
    background: white;
    padding: 12px;
    position: absolute;
    top: -35px;
    right: 20px;
    z-index: 1001;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    border-radius: 0 0 5px 5px;
}

/* --- LINKS Y HOVERS --- */

.nav-links {
    display: flex;
    list-style: none;
    gap: 40px;
    margin: 0;
    padding: 0;
    align-items: center;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-weight: 800;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    white-space: nowrap;
    position: relative;
    font-family: var(--fuente-principal);
}

/* Hover general para links blancos */
.nav-links a:not(.active-link-yellow):hover {
    color: var(--toni-amarillo);
    transform: translateY(-2px);
}

.active-link {
    color: var(--toni-amarillo) !important;
}

/* Estado especial para Ingresar Código */
.text-yellow-default {
    color: var(--toni-amarillo) !important;
}

.active-link-yellow {
    background-color: var(--toni-amarillo);
    color: var(--toni-azul-marino) !important;
    padding: 8px 15px !important;
    border-radius: 25px;
    box-shadow: 0 4px 0px #b39200;
    /* Efecto de profundidad */
}

.active-link-yellow:hover {
    transform: scale(1.05);
    background-color: #ffeb3b;
}

/* Responsive básico para evitar que se rompa en tablets */
@media (max-width: 1100px) {
    .nav-links {
        gap: 10px;
    }

    .nav-links a {
        font-size: 0.75rem;
    }

    .logo-pasion {
        height: 90px;
        top: -25px;
    }

    .logo-toni-mundial {
        height: 110px;
    }
}
</style>