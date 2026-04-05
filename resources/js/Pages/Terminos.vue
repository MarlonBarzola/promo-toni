<script setup>
import LandingLayout from '@/Layouts/LandingLayout.vue';
import SeoHead from '@/Components/Common/SeoHead.vue';

const props = defineProps({
    contenido: String,
});
</script>

<template>
    <SeoHead
        title="Términos y Condiciones - Alimentando la pasión del hincha con Toni"
        description="Lee los términos y condiciones de la promoción Alimentando la pasión del hincha con Toni."
    />
    <LandingLayout>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terminos-content text-white">
                        <div v-if="contenido" v-html="contenido" class="tiptap-output" />
                        <p v-else class="text-center text-white">
                            Los términos y condiciones aún no han sido publicados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>

<style scoped>
.terminos-content {
    font-size: 1rem;
    line-height: 1.6;
    padding-right: 15px;
}

:deep(.tiptap-output h1) { font-weight: bold; margin-bottom: 0.5rem; }
:deep(.tiptap-output h2) { font-weight: bold; margin-bottom: 0.5rem; }
:deep(.tiptap-output h3) { font-weight: bold; margin-bottom: 0.4rem; }
:deep(.tiptap-output p)  { margin-bottom: 0.8rem; }
:deep(.tiptap-output ul) { padding-left: 1.5rem; margin-bottom: 0.8rem; list-style: disc; }
:deep(.tiptap-output ol) { padding-left: 1.5rem; margin-bottom: 0.8rem; list-style: decimal; }
:deep(.tiptap-output li) { display: list-item; }
</style>
