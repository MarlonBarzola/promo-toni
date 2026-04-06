<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PasswordInput from '@/Components/Landing/PasswordInput.vue';

const emit = defineEmits(['success', 'go-register']);

// modo: login | forgot
const modo = ref('login');

// LOGIN
const form = useForm({
    login: '',
    password: '',
    remember: false,
});

// FORGOT PASSWORD
const forgotForm = useForm({
    email: '',
});

const enviado = ref(false);

// login
const submit = () => {
    form.post(route('login'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => form.reset('password'),
    });
};

// recuperar contraseña
const enviarRecuperacion = () => {
    forgotForm.post(route('password.email'), {
        onSuccess: () => {
            enviado.value = true;
            forgotForm.reset();
        }
    });
};
</script>

<template>
    <div class="form-card">
        <h2 class="text-center text-dark-blue text-uppercase">
            {{ modo === 'login' ? 'Iniciar sesión' : 'RECUPERAR CONTRASEÑA' }}
        </h2>

        <!-- ir a registro -->
        <span v-if="modo === 'login'" class="d-block text-center text-primary fw-bold cursor-pointer"
            @click="emit('go-register')">
            ¿Aún no tienes una cuenta?
            <span class="text-white">Regístrate aquí</span>
        </span>

        <!-- alerta verificación correo -->
        <div v-if="form.errors.verification_required" class="verification-box">
            {{ form.errors.verification_required }}
        </div>

        <!-- mensaje éxito -->
        <div v-if="enviado" class="success-box">
            Revisa tu correo para restablecer tu contraseña
        </div>

        <!-- LOGIN -->
        <form v-if="modo === 'login'" @submit.prevent="submit" class="mt-4">
            <div class="mb-2">
                <input type="text" v-model="form.login" placeholder="Usuario o correo electrónico:" class="form-input"
                    :class="{ 'input-error': form.errors.login }" autocomplete="username">
                <div v-if="form.errors.login" class="error-message">
                    {{ form.errors.login }}
                </div>
            </div>

            <div class="mb-2">
                <PasswordInput v-model="form.password" placeholder="Contraseña:" autocomplete="current-password" :has-error="!!form.errors.password" />
                <div v-if="form.errors.password" class="error-message">
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- link forgot -->
            <span class="forgot-link" @click="modo = 'forgot'">
                ¿Olvidaste tu contraseña?
            </span>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-dark-blue text-uppercase w-50" :disabled="form.processing">
                    {{ form.processing ? 'ENTRANDO...' : 'ENTRAR' }}
                </button>
            </div>
        </form>

        <!-- FORGOT PASSWORD -->
        <form v-else @submit.prevent="enviarRecuperacion" class="mt-4">
            <div class="mb-2">
                <input type="email" v-model="forgotForm.email" placeholder="Correo electrónico:" class="form-input"
                    :class="{ 'input-error': forgotForm.errors.email }">
                <div v-if="forgotForm.errors.email" class="error-message">
                    {{ forgotForm.errors.email }}
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark-blue text-uppercase w-50" :disabled="forgotForm.processing">
                    {{ forgotForm.processing ? 'ENVIANDO...' : 'ENVIAR LINK' }}
                </button>
            </div>

            <!-- volver -->
            <span class="back-link" @click="modo = 'login'; enviado = false">
                Iniciar sesión
            </span>
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

.error-message {
    color: var(--toni-azul-oscuro);
    font-size: 0.75rem;
    font-weight: bold;
    margin-top: 2px;
    padding-left: 5px;
}

.input-error {
    border: 2px solid var(--toni-azul-oscuro) !important;
    background: rgba(0, 37, 90, 0.1) !important;
}

.forgot-link,
.back-link {
    display: block;
    margin-top: 10px;
    font-size: 0.85rem;
    color: white;
    cursor: pointer;
    text-align: center;
    text-decoration: underline;
}

.verification-box {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
    padding: 12px;
    border-radius: 10px;
    margin-top: 10px;
    text-align: center;
    font-weight: bold;
    font-size: 0.85rem;
}

.success-box {
    background: #d1fae5;
    color: #065f46;
    padding: 12px;
    border-radius: 10px;
    margin-top: 10px;
    text-align: center;
    font-weight: bold;
}
</style>