<script setup lang="ts">
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

const props = defineProps<{
    title: string;
}>();

const { title } = props;
</script>

<template>
    <Head :title="title" />
    <div class="wrapper">
        <div class="content">
            <Link href="/">
                <ApplicationLogo :size="120" />
            </Link>
            <slot />
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    @apply min-h-screen flex flex-col justify-center items-center pt-6 bg-welcome-background bg-cover bg-center;
}

.content {
    @apply flex flex-col items-center justify-center w-full -translate-y-[15%];
}
</style>
