<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

// Comprobar si la ruta actual coincide con el nombre de la ruta o la URL
const isUrlActive = (url) => page.url === url;
const isRouteActive = (routeName) => route().current(routeName);
</script>

<template>
    <nav class="navbar-custom">
        <div class="container-nav">
            <div class="nav-logo">
                <img src="/img/logo-pasion.png" alt="Logo Pasión" class="img-logo">
            </div>

            <ul class="nav-links">
                <li>
                    <Link href="/" :class="{ 'active-link': isUrlActive('/') }">
                        INICIO
                    </Link>
                </li>
                <li>
                    <Link :href="route('dashboard')" :class="{ 'active-link': isRouteActive('dashboard') }"
                        class="text-yellow-default">
                        INGRESAR CÓDIGO
                    </Link>
                </li>
                <li>
                    <a href="#productos" :class="{ 'active-link': isUrlActive('/#productos') }">
                        PRODUCTOS PARTICIPANTES
                    </a>
                </li>
                <li>
                    <a href="#terminos" :class="{ 'active-link': isUrlActive('/#terminos') }">
                        TÉRMINOS Y CONDICIONES
                    </a>
                </li>
            </ul>

            <div class="nav-brand-toni">
                <img src="/img/logo-toni-mundial.png" alt="Toni" class="img-toni">
            </div>
        </div>
    </nav>
</template>

<style scoped>
/* Estilos base del Navbar que ya tenías */
.navbar-custom {
    background-color: var(--toni-azul-marino);
    width: 100%;
    padding: 15px 0;
    border-bottom: 3px solid var(--toni-celeste);
    position: relative;
    z-index: 1000;
}

.container-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.nav-links {
    display: flex;
    list-style: none;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    font-size: 0.8rem;
    transition: 0.3s;
    padding-bottom: 5px;
}

/* --- CLASES DE ESTADO ACTIVO --- */

/* Resalte para links blancos (Inicio, etc) */
.active-link {
    color: var(--toni-amarillo) !important;
}

/* Resalte especial para "Ingresar Código" (Amarillo) */
.text-yellow-default {
    color: var(--toni-amarillo);
}

.active-link-yellow {
    color: white !important;
    background-color: var(--toni-amarillo);
    padding: 5px 12px !important;
    border-radius: 20px;
    color: var(--toni-azul-marino) !important;
}

/* Hover general */
.nav-links a:hover {
    color: var(--toni-celeste);
}

.img-logo {
    height: 60px;
}

.img-toni {
    height: 70px;
    background: white;
    padding: 5px;
    border-radius: 5px;
}
</style>