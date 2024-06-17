<script setup lang="ts">
defineProps<{
    title: string;
    content: string;
}>();
</script>

<template>
    <div class="dialog-cell">
        <p class="dialog-cell__title">{{ title }}</p>
        <p>{{ content }}</p>
    </div>
</template>

<style scoped lang="scss">
.dialog-cell {
    @apply mb-2;

    &__title {
        @apply font-bold;
    }
}
</style>
