<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="/images/logo-toni.jpg">
        <link rel="shortcut icon" type="image/jpeg" href="/images/logo-toni.jpg">

        <!-- SEO base (sobreescrito por cada página vía @inertiaHead) -->
        <meta name="description" content="Registra tus empaques. ¡Participa por paquetes futboleros y gana premios semanales!">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ config('app.url') }}">

        <!-- Open Graph / WhatsApp / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:url" content="{{ config('app.url') }}">
        <meta property="og:title" content="Alimentando la pasión del hincha con Toni">
        <meta property="og:description" content="Registra tus empaques. ¡Participa por paquetes futboleros y gana premios semanales!">
        <meta property="og:image" content="{{ config('app.url') }}/images/og-image.jpg">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:locale" content="es_EC">

        <!-- Twitter / X -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Alimentando la pasión del hincha con Toni">
        <meta name="twitter:description" content="Registra tus empaques. ¡Participa por paquetes futboleros y gana premios semanales!">
        <meta name="twitter:image" content="{{ config('app.url') }}/images/og-image.jpg">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <style>
            #page-loader {
                position: fixed;
                inset: 0;
                z-index: 99999;
                background-color: #000c93;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: opacity 0.4s ease;
            }
            #page-loader.fade-out {
                opacity: 0;
                pointer-events: none;
            }
            .loader-logo {
                width: min(260px, 60vw);
                animation: loader-pulse 1.4s ease-in-out infinite;
            }
            @keyframes loader-pulse {
                0%, 100% { opacity: 1; }
                50%       { opacity: 0.5; }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Splash screen: visible antes de que Vue monte -->
        <div id="page-loader">
            <img src="/images/logo-pasion.png" alt="Cargando..." class="loader-logo">
        </div>

        @inertia
    </body>
</html>
