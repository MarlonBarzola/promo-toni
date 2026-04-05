<script setup>
import { ref } from 'vue';

const props = defineProps({
    placeholder: { type: String, default: 'Contraseña:' },
    autocomplete: { type: String, default: 'current-password' },
    hasError: { type: Boolean, default: false },
});

const model = defineModel({ type: String, required: true });

const visible = ref(false);
</script>

<template>
    <div class="password-wrapper">
        <input
            :type="visible ? 'text' : 'password'"
            v-model="model"
            :placeholder="placeholder"
            :autocomplete="autocomplete"
            class="form-input"
            :class="{ 'input-error': hasError }"
        />
        <button type="button" class="eye-btn" @click="visible = !visible" tabindex="-1" :aria-label="visible ? 'Ocultar contraseña' : 'Mostrar contraseña'">
            <!-- Eye open -->
            <svg v-if="!visible" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            <!-- Eye off -->
            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
        </button>
    </div>
</template>

<style scoped>
.password-wrapper {
    position: relative;
    width: 100%;
}

.password-wrapper .form-input {
    padding-right: 42px;
}

.eye-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    color: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    line-height: 1;
}

.eye-btn:hover {
    color: white;
}

.eye-btn svg {
    width: 20px;
    height: 20px;
}
</style>
