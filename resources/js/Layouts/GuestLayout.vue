<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import MobileGuestLayout from "@js/Layouts/MobileGuestLayout.vue";
import DesktopGuestLayout from "@js/Layouts/DesktopGuestLayout.vue";
import { computed } from "vue";
import useWindowWidth from "@js/hooks/useScreenWidth";

defineProps<{
    title: string;
}>();

const width = useWindowWidth();

const currentLayout = computed(() => {
    if (width.value >= 1024) return DesktopGuestLayout;
    return MobileGuestLayout;
});
</script>

<template>
    <Head :title="title" />
    <component :is="currentLayout">
        <slot />
    </component>
</template>
