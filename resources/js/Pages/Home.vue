<script setup>
import Ranking from '@/Components/Ranking.vue';

defineProps({
    ranking: Array
});
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <Ranking :ranking="ranking" />
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</template>