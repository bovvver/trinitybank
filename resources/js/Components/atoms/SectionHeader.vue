<script setup lang="ts">
import ApplicationLogo from "./ApplicationLogo.vue";

defineProps<{
    value: string;
}>();
</script>

<template>
    <h2 class="header"><ApplicationLogo :size="30" /> {{ value }}</h2>
</template>

<style scoped>
.header {
    @apply text-2xl font-bold px-3 pt-10 flex items-center gap-1;
}
</style>
