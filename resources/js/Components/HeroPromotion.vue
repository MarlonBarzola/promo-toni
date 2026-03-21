<template>
    <div class="hero-main">
        <div class="cancha-bg"></div>

        <div class="container position-relative z-10">
            <div class="row align-items-center py-5">
                <div class="col-lg-6 text-center">
                    <img src="/images/logo-lonchera.png" alt="Tu Pasión de Hincha Toni"
                        class="img-fluid img-promo-main">
                </div>

                <div class="col-lg-6">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hero-main {
    position: relative;
    background-color: var(--toni-azul-marino);
    overflow: hidden;
    display: flex;
    align-items: center;
    min-height: 80vh;
}

.cancha-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('/images/fondo-lineas-estadio.png');
    background-size: cover;
    background-position: center;
    opacity: 0.6;
    z-index: 1;
}

.z-10 {
    z-index: 10;
}

.img-promo-main {
    max-width: 100%;
    filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
}

@media (max-width: 991px) {
    .hero-main {
        padding: 60px 0;
    }
}
</style>