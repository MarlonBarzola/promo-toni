<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const menuAbierto = ref(false);
const navRef = ref(null);

const handleClickOutside = (event) => {
    if (menuAbierto.value && navRef.value && !navRef.value.contains(event.target)) {
        menuAbierto.value = false;
    }
};

onMounted(() => document.addEventListener('click', handleClickOutside));
onUnmounted(() => document.removeEventListener('click', handleClickOutside));

const user = page.props.auth?.user;
const registroHabilitado = computed(() => page.props.settings?.registro_habilitado ?? false);

const emit = defineEmits(['open-login']);

const isUrlActive = (url) => page.url === url;
const isRouteActive = (routeName) => route().current(routeName);

const toggleMenu = () => {
    menuAbierto.value = !menuAbierto.value;
};

const logout = () => {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            router.visit('/', { replace: true });
        }
    });
};

</script>

<template>
    <div>
        <nav class="navbar-custom" ref="navRef">
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

                <ul class="nav-links text-uppercase" :class="{ 'show': menuAbierto }">
                    <li @click="menuAbierto = false">
                        <Link href="/" :class="{ 'active-link': isUrlActive('/') }">INICIO</Link>
                    </li>

                    <li @click="menuAbierto = false">
                        <Link v-if="user" :href="route('dashboard')"
                            :class="{ 'active-link': isRouteActive('dashboard') }">
                            INGRESAR CÓDIGO
                        </Link>

                        <a v-else-if="registroHabilitado" href="#" @click.prevent="$emit('open-login')">
                            INGRESAR CÓDIGO
                        </a>
                    </li>

                    <li @click="menuAbierto = false">
                        <Link :href="route('productos')" :class="{ 'active-link': isRouteActive('productos') }">
                            Productos Participantes
                        </Link>
                    </li>

                    <li @click="menuAbierto = false">
                        <Link :href="route('ganadores')" :class="{ 'active-link': isRouteActive('ganadores') }">
                            GANADORES SEMANALES
                        </Link>
                    </li>

                    <li @click="menuAbierto = false">
                        <Link :href="route('terminos')" :class="{ 'active-link': isRouteActive('terminos') }">
                            TÉRMINOS Y CONDICIONES
                        </Link>
                    </li>

                    <li @click="menuAbierto = false">
                        <Link :href="route('faq')" :class="{ 'active-link': isRouteActive('faq') }">
                            PREGUNTAS FRECUENTES
                        </Link>
                    </li>

                    <li v-if="user" @click="menuAbierto = false">
                        <a @click="logout" class="logout-btn">
                            CERRAR SESIÓN
                        </a>
                    </li>
                </ul>

                <div class="logo-wrapper-right">
                    <img src="/images/logo-toni.jpg" alt="Toni Camino al Mundial" class="logo-toni-mundial">
                </div>
            </div>
        </nav>

        <div class="logo-mobile d-lg-none">
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
    display: flex;
    align-items: center;
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
    height: 80px;
    background-image: url(/images/curva.png);
    background-size: 15%;
    background-repeat: no-repeat;
    background-position: left bottom;
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
    top: 60px;
    left: 7.5%; /* Centrado sobre curva (background-size: 15%) */
    transform: translateX(-50%);
    z-index: 1002;
}

.logo-toni-mundial {
    height: 100px;
    width: auto;
    background: white;
    position: absolute;
    top: 0;
    right: 20px;
    z-index: 1001;
}

/* --- LINKS DESKTOP --- */
.nav-links {
    display: flex;
    list-style: none;
    gap: 20px;
    margin: 0 auto;
    padding: 0;
    align-items: center;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-size: 1.2rem;
    font-family: var(--fuente-principal);
    transition: 0.3s;
}

.active-link {
    color: var(--toni-amarillo) !important;
}

.logout-btn {
    background: none;
    border: none;
    color: white;
    font-size: 1.2rem;
    font-family: var(--fuente-principal);
    cursor: pointer;
    transition: 0.3s;
    padding: 0;
}

.logout-btn:hover {
    color: var(--toni-amarillo);
}

.logo-mobile {
    background-color: var(--toni-azul-marino);
}

.logo-mobile img {
    max-width: 25%;
    display: block;
    margin: 0 auto;
}

.nav-button {
    background: none;
    border: none;
    color: white;
    font-weight: 800;
    font-size: 1rem;
    font-family: var(--fuente-principal);
    cursor: pointer;
    transition: 0.3s;
    padding: 0;
}

.nav-button:hover {
    color: var(--toni-amarillo);
}

/* --- MEDIA QUERY: MOBILE --- */
@media (max-width: 991px) {
    .container-nav {
        background-size: 35%;
        background-position: center bottom;
    }

    .menu-toggle {
        display: flex;
    }

    .logo-pasion {
        height: 80px;
        left: 50%;
        transform: translateX(-50%);
        top: -15px;
    }

    .logo-toni-mundial {
        height: 90px;
    }

    .logo-wrapper-left,
    .logo-wrapper-right {
        width: 40px;
    }

    .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
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
    }

    .nav-links a,
    .logout-btn {
        font-size: 1.5rem;
        display: block;
    }

    .nav-links a:hover,
    .logout-btn:hover {
        color: var(--toni-amarillo);
    }

    .menu-toggle.open span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .menu-toggle.open span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.open span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -8px);
    }

    .nav-button {
        font-size: 1.5rem;
        display: block;
    }
}
</style>