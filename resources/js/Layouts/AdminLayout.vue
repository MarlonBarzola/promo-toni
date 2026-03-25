<script setup>
import Sidebar from '@/Components/Admin/Sidebar.vue';
import { router } from '@inertiajs/vue3';
import '../../css/admin.css';

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
</style>