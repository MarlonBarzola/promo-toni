<script setup>
import { Link} from '@inertiajs/vue3';
</script>
<template>
    <footer class="footer-toni py-4">
        <div class="container d-flex align-items-center justify-content-center flex-wrap">
            <div class="footer mb-2">
                <div class="info">
                    <span>
                        Para más información ingresa a
                    </span>
                    <div class="text-uppercase icons-social">
                        <div class="icons-row">
                            <a href="https://www.instagram.com/pasiondelhinchatoni/" target="_blank" class="flex align-items-center">
                                <img src="/images/instagram.svg" alt="instagram" class="icon-social" loading="lazy">
                                @pasiondelhinchatoni
                            </a>
                            <a href="https://www.instagram.com/tonilacteos/" target="_blank" class="flex align-items-center">
                                <img src="/images/instagram.svg" alt="instagram" class="icon-social" loading="lazy">
                                @tonilacteos
                            </a>
                        </div>
                        <div class="icons-row">
                            <a href="https://www.facebook.com/Tonilacteos " target="_blank" class="flex align-items-center">
                                <img src="/images/facebook.svg" alt="facebook" class="icon-social" loading="lazy">
                                tonilacteos
                            </a>
                        </div>
                    </div>
                </div>
                <div class="leyenda">
                    Promoción válida desde el 6 de abril hasta 28 junio de 2026 o hasta agotar stock. Anuncio de ganadores paquetes mundialistas: 31 mayo 2026. <Link class="underline" :href="route('terminos')">Aplican términos y condiciones.</Link>
                </div>
            </div>
            <div>
                <img src="/images/footer.svg" alt="Global Brand Awards" class="logo-footer" loading="lazy">
            </div>
        </div>
    </footer>
</template>

<style scoped>
.footer-toni {
    color: white;
    background-color: var(--toni-azul-marino);
    position: relative;
    z-index: 10;
}
.footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.info {
    font-family: var(--fuente-principal);
    font-size: 15px;
}
.info span {
    display: block;
    margin-bottom: 5px;
    font-size: 20px;
}
.info > div {
    font-size: 25px;
}
.logo-footer {
    width: 150px;
}
.leyenda {
    font-size: 13px;
    text-align: right;
    max-width: 40%;
}
.x-small {
    font-size: 0.7rem;
    line-height: 1.2;
}
.icons-social {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.icons-row {
    display: flex;
    gap: 10px;
}
.icon-social {
    width: 30px;
    height: 30px;
    margin-right: 5px;
}
.icons-social a:hover {
    filter: drop-shadow(0 4px 6px rgba(255, 255, 255, 0.5));
}
@media (max-width: 991px) {
    .footer {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    .leyenda {
        text-align: center;
        max-width: 50%;
        margin-bottom: 1rem;
    }
    .icons-social {
        align-items: center;
    }
    .icons-row {
        flex-direction: column;
        align-items: center;
    }
}
</style>