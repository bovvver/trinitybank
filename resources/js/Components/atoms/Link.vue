<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Button from "primevue/button";

defineProps<{
    route: string;
    content: string;
    link?: boolean;
    severity?: string;
}>();
</script>

<template>
    <Link :href="route">
        <Button
            :link="link"
            :class="{ link: link }"
            :severity="severity"
            class="w-full"
            :label="content"
        />
    </Link>
</template>

<style scoped>
.link {
    @apply underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-max;
}
</style>
