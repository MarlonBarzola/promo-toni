<script setup>
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['success', 'go-register']);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        preserveScroll: false,
        onSuccess: () => {
            window.scrollTo({
                top: 0,
                behavior: 'auto'
            });
        },
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="form-card">
        <h2 class="text-center">INICIA SESIÓN</h2>
        <span class="d-block text-center text-primary fw-bold cursor-pointer" @click="emit('go-register')">
            ¿Aún no tienes una cuenta? <span class="text-yellow">Regístrate aquí</span>
        </span>
        <form @submit.prevent="submit" class="mt-4">
            <div class="mb-2">
                <input type="email" v-model="form.email" placeholder="Correo electrónico:" class="form-input"
                    :class="{ 'input-error': form.errors.email }" autocomplete="username">
                <div v-if="form.errors.email" class="error-message">{{ form.errors.email }}</div>
            </div>

            <div class="mb-4">
                <input type="password" v-model="form.password" placeholder="Contraseña:" class="form-input"
                    :class="{ 'input-error': form.errors.password }" autocomplete="current-password">
                <div v-if="form.errors.password" class="error-message">{{ form.errors.password }}</div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark-blue text-uppercase w-50" :disabled="form.processing">
                    {{ form.processing ? 'ENTRANDO...' : 'ENTRAR' }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.form-card {
    background-color: var(--toni-celeste);
    padding: 20px;
    border-radius: 30px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    max-width: 450px;
    margin: 0 auto;
    position: relative;
    z-index: 10;
}

.form-title {
    font-family: 'Bebas Neue', sans-serif;
    color: var(--toni-azul-marino);
    font-size: 2.2rem;
    margin: 0;
}

.form-input {
    width: 100%;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    color: white;
    padding: 10px 12px;
    font-weight: bold;
    outline: none;
}

.form-input::placeholder {
    color: rgba(255, 255, 255, 0.8);
}

.btn-enviar-toni {
    background-color: var(--toni-azul-marino);
    color: white;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.8rem;
    padding: 10px;
    border-radius: 50px;
    border: none;
    transition: 0.3s;
    box-shadow: 0 5px 0px #00255a;
}

.error-message {
    color: var(--toni-amarillo);
    font-size: 0.75rem;
    font-weight: bold;
    margin-top: 2px;
    padding-left: 5px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

.input-error {
    border: 2px solid var(--toni-amarillo) !important;
    background: rgba(255, 218, 0, 0.1) !important;
}
</style>