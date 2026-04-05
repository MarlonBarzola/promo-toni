<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

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
