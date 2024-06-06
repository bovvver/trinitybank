<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import DesktopAuthenticatedLayout from "@js/Layouts/DesktopAuthenticatedLayout.vue";
import MobileAuthenticatedLayout from "@js/Layouts/MobileAuthenticatedLayout.vue";
import { computed } from "vue";
import useWindowWidth from "@js/hooks/useScreenWidth";

defineProps<{
    title: string;
}>();

const width = useWindowWidth();

const currentLayout = computed(() => {
    if (width.value >= 1024) return DesktopAuthenticatedLayout;
    return MobileAuthenticatedLayout;
});
</script>

<template>
    <Head :title="title" />
    <component :is="currentLayout">
        <slot />
    </component>
</template>
