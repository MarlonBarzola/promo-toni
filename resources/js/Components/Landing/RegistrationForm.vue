<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    apellido: '',
    cedula: '',
    ciudad: '',
    fecha_nacimiento: '',
    email: '',
    acepto_terminos: false,
});

const submit = () => {
    form.post(route('registro.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div class="form-card">
        <h2 class="text-center">REGISTRA TUS DATOS</h2>

        <form @submit.prevent="submit" class="mt-4">
            <div class="mb-2">
                <input type="text" v-model="form.nombre" placeholder="Nombre:" class="form-input" required>
            </div>
            <div class="mb-2">
                <input type="text" v-model="form.apellido" placeholder="Apellido:" class="form-input" required>
            </div>
            <div class="mb-2">
                <input type="text" v-model="form.cedula" placeholder="Cédula:" class="form-input" required>
            </div>
            <div class="mb-2">
                <input type="text" v-model="form.ciudad" placeholder="Ciudad:" class="form-input" required>
            </div>
            <div class="mb-2">
                <input type="date" v-model="form.fecha_nacimiento" class="form-input" required>
            </div>
            <div class="mb-4">
                <input type="email" v-model="form.email" placeholder="Correo electrónico:" class="form-input" required>
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
    background-color: #00aeef;
    padding: 40px;
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
</style>