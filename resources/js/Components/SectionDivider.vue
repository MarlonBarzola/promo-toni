<template>
    <div class="divider-container d-none d-md-block" :style="{ backgroundColor: bgTop }">
        <div class="slope" :style="{ backgroundColor: bgBottom }"></div>
    </div>
</template>

<script setup>
defineProps({
    bgTop: {
        type: String,
        default: '#001a57'
    },
    bgBottom: {
        type: String,
        default: '#002b85'
    }
});
</script>

<style scoped>
.divider-container {
    width: 100%;
    height: 100px;
    position: relative;
    overflow: hidden;
    margin-top: -1px;
    margin-bottom: -1px;
}

.slope {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    clip-path: polygon(0 100%, 100% 100%, 100% 0);
}

@media (max-width: 768px) {
    .divider-container {
        height: 50px;
        /* Inclinación más suave en móviles */
    }
}
</style>