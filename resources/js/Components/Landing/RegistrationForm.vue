<script setup>
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import PasswordInput from '@/Components/Landing/PasswordInput.vue';

const emit = defineEmits(['success', 'go-login']);

const form = useForm({
    nombre: '',
    apellido: '',
    cedula: '',
    telefono: '',
    ciudad: '',
    fecha_nacimiento: null,
    email: '',
    usuario: '',
    password: '',
    password_confirmation: '',
    acepto_terminos: false,
    acepto_privacidad: false,
});

const masks = {
    modelValue: 'YYYY-MM-DD',
};

const fechaDisplay = ref('');

const maxFechaNacimiento = computed(() => {
    const d = new Date();
    d.setFullYear(d.getFullYear() - 18);
    return d;
});

const initialPage = computed(() => ({
    month: maxFechaNacimiento.value.getMonth() + 1,
    year: maxFechaNacimiento.value.getFullYear(),
}));

// Sync display when calendar picker selects a date
watch(() => form.fecha_nacimiento, (val) => {
    if (val) {
        const [y, m, d] = val.split('-');
        const formatted = `${d}/${m}/${y}`;
        if (formatted !== fechaDisplay.value) {
            fechaDisplay.value = formatted;
        }
    }
});

const handleFechaInput = (e) => {
    // Keep only digits, max 8 (ddmmyyyy)
    const digits = e.target.value.replace(/\D/g, '').substring(0, 8);

    let formatted = digits;
    if (digits.length > 4) {
        formatted = `${digits.substring(0, 2)}/${digits.substring(2, 4)}/${digits.substring(4)}`;
    } else if (digits.length > 2) {
        formatted = `${digits.substring(0, 2)}/${digits.substring(2)}`;
    }

    fechaDisplay.value = formatted;
    e.target.value = formatted;

    if (digits.length === 8) {
        form.fecha_nacimiento = `${digits.substring(4, 8)}-${digits.substring(2, 4)}-${digits.substring(0, 2)}`;
    } else {
        form.fecha_nacimiento = null;
    }
};

const enviado = ref(false);

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => {
            enviado.value = true;
            form.reset();
        },
    });
};

</script>

<template>
    <div class="form-card">
        <h2 class="text-center text-dark-blue">REGISTRA TUS DATOS</h2>
        <span class="d-block text-center text-primary fw-bold cursor-pointer" @click="emit('go-login')">
            ¿Ya tienes una cuenta? <span class="text-white">Ingresa aquí</span>
        </span>
        <form v-if="!enviado" @submit.prevent="submit" class="mt-4" autocomplete="off">
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
                <input type="tel" v-model="form.telefono" placeholder="Teléfono:" class="form-input"
                    :class="{ 'input-error': form.errors.telefono }">
                <div v-if="form.errors.telefono" class="error-message">{{ form.errors.telefono }}</div>
            </div>

            <div class="mb-2">
                <input type="text" v-model="form.ciudad" placeholder="Ciudad:" class="form-input"
                    :class="{ 'input-error': form.errors.ciudad }">
                <div v-if="form.errors.ciudad" class="error-message">{{ form.errors.ciudad }}</div>
            </div>

            <div class="mb-2">
                <DatePicker v-model.string="form.fecha_nacimiento" :masks="{ modelValue: 'YYYY-MM-DD' }" mode="date"
                    :popover="{ visibility: 'click' }" locale="es"
                    :max-date="maxFechaNacimiento"
                    :initial-page="initialPage">
                    <template #default="{ inputEvents }">
                        <input class="form-input" :class="{ 'input-error': form.errors.fecha_nacimiento }"
                            placeholder="Fecha de nacimiento: (dd/mm/aaaa)" :value="fechaDisplay"
                            v-on="{ ...inputEvents, input: handleFechaInput }"
                            inputmode="numeric" maxlength="10" />
                    </template>
                </DatePicker>
                <div v-if="form.errors.fecha_nacimiento" class="error-message">
                    {{ form.errors.fecha_nacimiento }}
                </div>
            </div>

            <div class="mb-2">
                <input type="text" inputmode="email" v-model="form.email" placeholder="Correo electrónico:" class="form-input"
                    :class="{ 'input-error': form.errors.email }">
                <div v-if="form.errors.email" class="error-message">{{ form.errors.email }}</div>
            </div>

            <div class="mb-2">
                <input type="text" v-model="form.usuario" placeholder="Usuario:" class="form-input"
                    :class="{ 'input-error': form.errors.usuario }">
                <div v-if="form.errors.usuario" class="error-message">{{ form.errors.usuario }}</div>
            </div>

            <div class="mb-2">
                <PasswordInput v-model="form.password" placeholder="Contraseña:" autocomplete="new-password" :has-error="!!form.errors.password" />
                <div v-if="form.errors.password" class="error-message">{{ form.errors.password }}</div>
            </div>

            <div class="mb-4">
                <PasswordInput v-model="form.password_confirmation" placeholder="Confirmar Contraseña:" autocomplete="new-password" />
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" v-model="form.acepto_terminos" id="checkTerminos"
                    required>
                <label class="form-check-label text-white small" for="checkTerminos">
                    Acepto los términos y condiciones y reconozco que, en caso de resultador ganador del paquete futbolero, la documentación para viajar a Estados Unidos (incluida visa vigente) es mi responsabilidad, y que el organizador no se hace responsable por su gestión, obtención o rechazo.
                </label>
                <div v-if="form.errors.acepto_terminos" class="error-message">{{ form.errors.acepto_terminos }}</div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" v-model="form.acepto_privacidad" id="checkPrivacidad"
                    required>
                <label class="form-check-label text-white small" for="checkPrivacidad">
                    Acepto el tratamiento de mis datos personales de acuerdo con la política de privacidad.
                </label>
                <div v-if="form.errors.acepto_privacidad" class="error-message">{{ form.errors.acepto_privacidad }}</div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark-blue text-uppercase w-50" :disabled="form.processing">
                    {{ form.processing ? 'ENVIANDO...' : 'ENVIAR' }}
                </button>
            </div>
        </form>
        <div v-else class="success-box">
            Enviamos un enlace de verificación a tu correo. Confírmalo para ingresar.
            <br>
            Revisa también en Correos no deseados.
        </div>
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

.success-box {
    background:#03fd6547;
    color: var(--toni-azul-oscuro);
    padding: 15px;
    border-radius: 10px;
    margin-top: 10px;
    text-align: center;
    font-weight: bold;
}
</style>