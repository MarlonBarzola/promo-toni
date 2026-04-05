import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap'; // Bootstrap JS
import './bootstrap';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const dismissLoader = () => {
    const loader = document.getElementById('page-loader');
    if (!loader) return;
    loader.classList.add('fade-out');
    loader.addEventListener('transitionend', () => loader.remove(), { once: true });
};

// Espera a que todo el contenido (imágenes, fuentes) esté cargado.
// Si tarda más de 5 segundos igual lo quita para no bloquear al usuario.
const dismissWhenReady = () => {
    const MAX_WAIT = 5000;
    const timer = setTimeout(dismissLoader, MAX_WAIT);

    if (document.readyState === 'complete') {
        clearTimeout(timer);
        requestAnimationFrame(dismissLoader);
    } else {
        window.addEventListener('load', () => {
            clearTimeout(timer);
            requestAnimationFrame(dismissLoader);
        }, { once: true });
    }
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);

        // Quitar splash cuando todas las imágenes y recursos estén cargados
        dismissWhenReady();

        return app;
    },
    progress: {
        color: '#FFD700',
        showSpinner: true,
        includeCSS: true,
    },
});
