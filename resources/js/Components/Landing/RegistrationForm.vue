<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    apellido: '',
    cedula: '',
    ciudad: '',
    fecha_nacimiento: '',
    email: '',
    password: '',
    password_confirmation: '',
    acepto_terminos: false,
});

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div class="form-card">
        <h2 class="text-center">REGISTRA TUS DATOS</h2>

        <form @submit.prevent="submit" class="mt-4">
            <div class="mb-2">
                <input type="text" v-model="form.nombre" placeholder="Nombre:" class="form-input"
                    :class="{ 'input-error': form.errors.nombre }">
                <div v-if="form.errors.nombre" class="error-message">{{ form.errors.nombre }}</div>
            </div>

            <div class="mb-2">
                <input type="text" v-model="form.apellido" placeholder="Apellido:" class="form-input"
                    :class="{ 'input-error': form.errors.apellido }">
                <div v-if="form.errors.apellido" class="error-message">{{ form.errors.apellido }}</div>
            </div>

            <div class="mb-2">
                <input type="text" v-model="form.cedula" placeholder="Cédula:" class="form-input"
                    :class="{ 'input-error': form.errors.cedula }">
                <div v-if="form.errors.cedula" class="error-message">{{ form.errors.cedula }}</div>
            </div>

            <div class="mb-2">
                <input type="text" v-model="form.ciudad" placeholder="Ciudad:" class="form-input"
                    :class="{ 'input-error': form.errors.ciudad }">
                <div v-if="form.errors.ciudad" class="error-message">{{ form.errors.ciudad }}</div>
            </div>

            <div class="mb-2">
                <input type="date" v-model="form.fecha_nacimiento" class="form-input"
                    :class="{ 'input-error': form.errors.fecha_nacimiento }">
                <div v-if="form.errors.fecha_nacimiento" class="error-message">{{ form.errors.fecha_nacimiento }}</div>
            </div>

            <div class="mb-2">
                <input type="email" v-model="form.email" placeholder="Correo electrónico:" class="form-input"
                    :class="{ 'input-error': form.errors.email }">
                <div v-if="form.errors.email" class="error-message">{{ form.errors.email }}</div>
            </div>
            <div class="mb-2">
                <input type="password" v-model="form.password" placeholder="Contraseña:" class="form-input"
                    :class="{ 'input-error': form.errors.password }">
                <div v-if="form.errors.password" class="error-message">{{ form.errors.password }}</div>
            </div>

            <div class="mb-4">
                <input type="password" v-model="form.password_confirmation" placeholder="Confirmar Contraseña:"
                    class="form-input">
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" v-model="form.acepto_terminos" id="checkTerminos"
                    required>
                <label class="form-check-label text-white small" for="checkTerminos">
                    Acepto Términos y Condiciones
                </label>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark-blue text-uppercase w-50" :disabled="form.processing">
                    {{ form.processing ? 'ENVIANDO...' : 'ENVIAR' }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
/* Pegamos aquí los estilos específicos del formulario que tenías en Home */
.form-card {
    background-color: var(--toni-celeste);
    padding: 20px;
    border-radius: 30px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    max-width: 450px;
    margin: 0 auto;
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
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

.input-error {
    border: 2px solid var(--toni-amarillo) !important;
    background: rgba(255, 218, 0, 0.1) !important;
}
</style>