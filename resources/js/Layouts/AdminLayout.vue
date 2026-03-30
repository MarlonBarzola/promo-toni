<script setup>
import Sidebar from '@/Components/Admin/Sidebar.vue';
import { router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="admin-container">

        <Sidebar />

        <div class="admin-main">

            <header class="admin-header">
                <h1>Panel Admin</h1>
                <button @click="logout">Cerrar sesión</button>
            </header>

            <main class="admin-content">
                <slot />
            </main>

        </div>

    </div>
</template>

<style scoped>
/* ── Layout ─────────────────────────────────────────────────── */
.admin-container {
    display: flex;
    height: 100vh;
    overflow: hidden;
}

.admin-main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.admin-header {
    background: white;
    padding: 15px 30px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.admin-content {
    flex: 1;
    overflow-y: auto;
    padding: 30px;
    background: #f3f4f6;
}

/* ── Slot content (child components) ─────────────────────────── */
:deep(.btn-logout) {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
}

:deep(.admin-stats) {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

:deep(.stat) {
    flex: 1;
    padding: 15px;
    border-radius: 10px;
    background: white;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

:deep(.stat span) {
    display: block;
    font-size: 0.9rem;
    color: #777;
}

:deep(.stat strong) {
    display: block;
    font-size: 1.5rem;
}

:deep(.pendiente) { border-left: 5px solid #ffc107; }
:deep(.aprobado)  { border-left: 5px solid #28a745; }
:deep(.rechazado) { border-left: 5px solid #dc3545; }

:deep(.admin-search) {
    margin-bottom: 15px;
}

:deep(.admin-search input) {
    width: 100%;
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    outline: none;
}

:deep(.admin-search input:focus) {
    border-color: #111827;
}

:deep(.admin-filters) {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

:deep(.admin-filters button) {
    padding: 8px 16px;
    border: none;
    background: #eee;
    border-radius: 20px;
    cursor: pointer;
}

:deep(.admin-filters button.active) {
    background: #111827;
    color: white;
}

:deep(.admin-grid) {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

:deep(.admin-card) {
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

:deep(.admin-card-header) {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

:deep(.admin-images) {
    padding: 15px;
}

:deep(.image-box) {
    text-align: center;
}

:deep(.image-box span) {
    display: block;
    font-size: 0.8rem;
    margin-bottom: 5px;
    color: #666;
}

:deep(.image-box img) {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
}

:deep(.admin-actions) {
    display: flex;
}

:deep(.admin-actions button) {
    flex: 1;
    padding: 12px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

:deep(.btn-approve) {
    background: #28a745;
    color: white;
}

:deep(.btn-reject) {
    background: #dc3545;
    color: white;
}

:deep(.estado-badge) {
    text-align: center;
    padding: 12px;
    font-weight: bold;
}

:deep(.estado-badge.aprobado) {
    background: #d4edda;
    color: #155724;
}

:deep(.estado-badge.rechazado) {
    background: #f8d7da;
    color: #721c24;
}

:deep(.empty-state) {
    text-align: center;
    padding: 60px;
    color: #777;
}

:deep(.pagination) {
    margin-top: 30px;
    text-align: center;
}

:deep(.pagination button) {
    margin: 3px;
    padding: 8px 12px;
    border: none;
    background: #eee;
    cursor: pointer;
}

:deep(.pagination button.active) {
    background: #111;
    color: white;
}
</style>