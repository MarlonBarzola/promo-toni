<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';
import { TextStyle } from '@tiptap/extension-text-style';
import { Color } from '@tiptap/extension-color';
import { Underline } from '@tiptap/extension-underline';

const props = defineProps({
    contenido: String,
});

const page = usePage();
const mensaje = computed(() => page.props.flash?.mensaje);

const form = useForm({
    contenido: props.contenido ?? '',
});

const editor = useEditor({
    content: form.contenido,
    extensions: [
        StarterKit,
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
        TextStyle,
        Color,
        Underline,
    ],
    onUpdate({ editor }) {
        form.contenido = editor.getHTML();
    },
});

onBeforeUnmount(() => editor.value?.destroy());

const submit = () => {
    form.put(route('admin.terminos.update'));
};

const colors = ['#ffffff', '#FFD700', '#00bcd4', '#f44336', '#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#000000'];

const setColor = (color) => {
    editor.value?.chain().focus().setColor(color).run();
};
</script>

<template>
    <AdminLayout>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Términos y Condiciones</h2>
                <button class="btn btn-warning px-4" @click="submit" :disabled="form.processing">
                    {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                </button>
            </div>

            <div v-if="mensaje" class="alert alert-success">{{ mensaje }}</div>

            <!-- Barra de herramientas -->
            <div class="editor-toolbar" v-if="editor">
                <!-- Formato de texto -->
                <div class="toolbar-group">
                    <button title="Negrita" @click="editor.chain().focus().toggleBold().run()"
                        :class="{ active: editor.isActive('bold') }">
                        <strong>B</strong>
                    </button>
                    <button title="Cursiva" @click="editor.chain().focus().toggleItalic().run()"
                        :class="{ active: editor.isActive('italic') }">
                        <em>I</em>
                    </button>
                    <button title="Subrayado" @click="editor.chain().focus().toggleUnderline().run()"
                        :class="{ active: editor.isActive('underline') }">
                        <u>U</u>
                    </button>
                </div>

                <!-- Párrafo y encabezados -->
                <div class="toolbar-group">
                    <button title="Párrafo" @click="editor.chain().focus().setParagraph().run()"
                        :class="{ active: editor.isActive('paragraph') }">P</button>
                    <button title="Título 1" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                        :class="{ active: editor.isActive('heading', { level: 1 }) }">H1</button>
                    <button title="Título 2" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                        :class="{ active: editor.isActive('heading', { level: 2 }) }">H2</button>
                    <button title="Título 3" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                        :class="{ active: editor.isActive('heading', { level: 3 }) }">H3</button>
                </div>

                <!-- Alineación -->
                <div class="toolbar-group">
                    <button title="Alinear izquierda" @click="editor.chain().focus().setTextAlign('left').run()"
                        :class="{ active: editor.isActive({ textAlign: 'left' }) }">⬅</button>
                    <button title="Centrar" @click="editor.chain().focus().setTextAlign('center').run()"
                        :class="{ active: editor.isActive({ textAlign: 'center' }) }">≡</button>
                    <button title="Alinear derecha" @click="editor.chain().focus().setTextAlign('right').run()"
                        :class="{ active: editor.isActive({ textAlign: 'right' }) }">➡</button>
                    <button title="Justificar" @click="editor.chain().focus().setTextAlign('justify').run()"
                        :class="{ active: editor.isActive({ textAlign: 'justify' }) }">☰</button>
                </div>

                <!-- Listas -->
                <div class="toolbar-group">
                    <button title="Lista con viñetas" @click="editor.chain().focus().toggleBulletList().run()"
                        :class="{ active: editor.isActive('bulletList') }">• Lista</button>
                    <button title="Lista numerada" @click="editor.chain().focus().toggleOrderedList().run()"
                        :class="{ active: editor.isActive('orderedList') }">1. Lista</button>
                </div>

                <!-- Color de texto -->
                <div class="toolbar-group color-group">
                    <span class="toolbar-label">Color:</span>
                    <button
                        v-for="color in colors"
                        :key="color"
                        class="color-btn"
                        :style="{ backgroundColor: color }"
                        :title="color"
                        @click="setColor(color)"
                    />
                </div>

                <!-- Deshacer / Rehacer -->
                <div class="toolbar-group">
                    <button title="Deshacer" @click="editor.chain().focus().undo().run()">↩</button>
                    <button title="Rehacer" @click="editor.chain().focus().redo().run()">↪</button>
                </div>
            </div>

            <!-- Área del editor -->
            <div class="editor-wrapper">
                <EditorContent :editor="editor" />
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.editor-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    background: #1e1e2e;
    border: 1px solid #444;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
    padding: 8px 12px;
    align-items: center;
}

.toolbar-group {
    display: flex;
    gap: 4px;
    align-items: center;
    padding-right: 8px;
    border-right: 1px solid #444;
}

.toolbar-group:last-child {
    border-right: none;
}

.toolbar-label {
    color: #aaa;
    font-size: 0.8rem;
    margin-right: 4px;
}

.editor-toolbar button {
    background: #2a2a3e;
    color: #e0e0e0;
    border: 1px solid #555;
    border-radius: 4px;
    padding: 4px 10px;
    cursor: pointer;
    font-size: 0.85rem;
    transition: background 0.2s;
    white-space: nowrap;
}

.editor-toolbar button:hover {
    background: #3a3a5e;
}

.editor-toolbar button.active {
    background: #FFD700;
    color: #000;
    border-color: #FFD700;
}

.color-btn {
    width: 22px !important;
    height: 22px !important;
    padding: 0 !important;
    border-radius: 50% !important;
    border: 2px solid #666 !important;
    cursor: pointer;
    min-width: unset !important;
}

.color-btn:hover {
    border-color: #fff !important;
    transform: scale(1.15);
}

.editor-wrapper {
    background: #12121f;
    border: 1px solid #444;
    border-radius: 0 0 8px 8px;
    min-height: 500px;
    padding: 20px 24px;
    color: #e0e0e0;
}

:deep(.ProseMirror) {
    outline: none;
    min-height: 460px;
    font-size: 1rem;
    line-height: 1.7;
}

:deep(.ProseMirror h1) { font-size: 1.8rem; font-weight: bold; margin-bottom: 0.5rem; }
:deep(.ProseMirror h2) { font-size: 1.4rem; font-weight: bold; margin-bottom: 0.5rem; }
:deep(.ProseMirror h3) { font-size: 1.2rem; font-weight: bold; margin-bottom: 0.4rem; }
:deep(.ProseMirror p) { margin-bottom: 0.8rem; }
:deep(.ProseMirror ul) { padding-left: 1.5rem; margin-bottom: 0.8rem; }
:deep(.ProseMirror ol) { padding-left: 1.5rem; margin-bottom: 0.8rem; }
</style>
