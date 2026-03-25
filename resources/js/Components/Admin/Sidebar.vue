<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <aside class="sidebar">
        <h2 class="logo">Admin</h2>

        <nav>
            <Link :href="route('admin.index')" class="nav-link">
                📦 Códigos
            </Link>

            <Link :href="route('admin.reportes')" class="nav-link">
                🧾 Reportes
            </Link>
        </nav>
    </aside>
</template>

<style scoped>
.sidebar {
    width: 240px;
    height: 100vh;
    background: #111827;
    color: white;
    padding: 20px;
    flex-shrink: 0;
}

.logo {
    margin-bottom: 30px;
}

.nav-link {
    display: block;
    padding: 10px;
    color: #ccc;
    text-decoration: none;
}

.nav-link:hover {
    background: #1f2937;
    color: white;
}
</style>