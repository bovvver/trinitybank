<script setup lang="ts">
defineProps<{
    name: string;
    modelError?: string;
    label?: string;
}>();
</script>

<template>
    <div class="flex flex-col">
        <label :for="name" class="capitalize">{{ label?? name }}</label>
        <slot :id="name" />
        <small v-if="modelError" class="text-red-600">{{ modelError }}</small>
    </div>
</template>
