import { ref } from 'vue';
<template>
    <footer class="footer-toni py-4">
        <div class="container">
            <div class="footer">
                <div class="info">
                    <span>
                        Para más información ingresa a
                    </span>
                    <div class="text-uppercase icons-social">
                        <a href="#" class="flex align-items-center">
                            <img src="/images/instagram.svg" alt="instagram" class="icon-social">
                            @Tonilacteos
                        </a>
                        <a href="#" class="flex align-items-center">
                            <img src="/images/facebook.svg" alt="facebook" class="icon-social">
                            Toni Lácteos Ec
                        </a>
                    </div>
                </div>
                <div class="leyenda">
                    <p>*Imágenes referenciales. Promoción válida desde el 1 de abril hasta el 1 de mayo de 2026</p>
                    <p>o hasta agotar stock. Aplican términos y condiciones.</p>
                </div>
                <div>
                    <img src="/images/footer.svg" alt="Global Brand Awards" class="logo-footer">
                </div>
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
}
.x-small {
    font-size: 0.7rem;
    line-height: 1.2;
}
.icons-social {
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
}
</style>