<script setup>
import { computed, onBeforeUnmount, ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    modelValue: {
        type: [Number, String, null],
        default: null,
    },
    selectedUser: {
        type: Object,
        default: null,
    },
    placeholder: {
        type: String,
        default: 'Buscar usuario...',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue', 'update:selectedUser']);

const query = ref('');
const loading = ref(false);
const results = ref([]);
const showResults = ref(false);

let debounceTimer = null;
let requestSequence = 0;

const hasQuery = computed(() => query.value.trim().length > 0);
const canSearch = computed(() => query.value.trim().length >= 3);

const formatLabel = (usuario) => {
    const nombreCompleto = [usuario.nombre, usuario.apellido].filter(Boolean).join(' ');
    return `${nombreCompleto} - ${usuario.usuario} - ${usuario.cedula ?? 'sin cedula'}`;
};

const searchUsers = async () => {
    if (!canSearch.value || props.disabled) {
        loading.value = false;
        results.value = [];
        showResults.value = false;
        return;
    }

    const currentRequest = ++requestSequence;
    loading.value = true;

    try {
        const response = await axios.get(route('admin.usuarios.buscar'), {
            params: { q: query.value.trim() },
        });

        if (currentRequest !== requestSequence) {
            return;
        }

        results.value = Array.isArray(response.data) ? response.data : [];
        showResults.value = true;
    } catch (error) {
        if (currentRequest === requestSequence) {
            results.value = [];
            showResults.value = true;
        }
    } finally {
        if (currentRequest === requestSequence) {
            loading.value = false;
        }
    }
};

watch(query, () => {
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }

    debounceTimer = setTimeout(() => {
        searchUsers();
    }, 300);
});

onBeforeUnmount(() => {
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }
});

const selectUser = (usuario) => {
    emit('update:modelValue', usuario.id);
    emit('update:selectedUser', usuario);

    query.value = '';
    results.value = [];
    showResults.value = false;
};

const onFocus = () => {
    if (results.value.length > 0) {
        showResults.value = true;
    }
};

const onBlur = () => {
    setTimeout(() => {
        showResults.value = false;
    }, 120);
};
</script>

<template>
    <div class="autocomplete-wrapper">
        <input
            v-model="query"
            type="text"
            class="form-control"
            :placeholder="placeholder"
            :disabled="disabled"
            @focus="onFocus"
            @blur="onBlur"
        />

        <div v-if="loading" class="autocomplete-feedback">Buscando...</div>
        <div v-else-if="hasQuery && !canSearch" class="autocomplete-feedback">Escribe al menos 3 caracteres.</div>

        <ul v-if="showResults" class="autocomplete-list">
            <li
                v-for="usuario in results"
                :key="usuario.id"
                class="autocomplete-item"
                @mousedown.prevent="selectUser(usuario)"
            >
                {{ formatLabel(usuario) }}
            </li>
            <li v-if="!loading && results.length === 0" class="autocomplete-empty">
                Sin resultados.
            </li>
        </ul>

        <div v-if="selectedUser" class="selected-user">
            ✓ {{ formatLabel(selectedUser) }}
        </div>
    </div>
</template>

<style scoped>
.autocomplete-wrapper {
    position: relative;
}

.autocomplete-feedback {
    color: #ffffff;
    font-size: 0.82rem;
    margin-top: 6px;
}

.autocomplete-list {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    right: 0;
    z-index: 30;
    max-height: 260px;
    overflow-y: auto;
    background: #ffffff;
    border: 1px solid #ced4da;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.14);
    margin: 0;
    padding: 0;
    list-style: none;
}

.autocomplete-item,
.autocomplete-empty {
    padding: 10px 12px;
    font-size: 0.92rem;
    line-height: 1.35;
}

.autocomplete-item {
    cursor: pointer;
}

.autocomplete-item:hover {
    background: #f8f9fa;
}

.autocomplete-empty {
    color: #6c757d;
}

.selected-user {
    margin-top: 10px;
    padding: 8px 10px;
    border-radius: 6px;
    background: #e8fbe9;
    color: #0f5132;
    font-size: 0.88rem;
    border: 1px solid #badbcc;
}
</style>