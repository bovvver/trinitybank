<script setup lang="ts">
import Card from "primevue/card";
</script>

<template>
    <Card class="card">
        <template #title class="title"><slot name="title" /></template>
        <template #subtitle><slot name="subtitle" /></template>
        <template #content>
            <slot name="content" />
        </template>
    </Card>
</template>

<style scoped>
.card {
    @apply w-4/5 bg-white bg-opacity-70 md:w-1/2 lg:w-1/3;
}
</style>
