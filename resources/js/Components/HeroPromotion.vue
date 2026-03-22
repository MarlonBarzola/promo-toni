<template>
    <div class="hero-main">
        <div class="container position-relative z-10">
            <div class="row align-items-center py-0 py-md-5">
                <div class="col-lg-6 text-center p-0">
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
}

.z-10 {
    z-index: 10;
}

.img-promo-main {
    max-width: 100%;
}

@media (max-width: 991px) {
    .hero-main {
        padding: 60px 0;
    }
}
</style>