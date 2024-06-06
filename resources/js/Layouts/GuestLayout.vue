<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import MobileGuestLayout from "@js/Layouts/MobileGuestLayout.vue";
import DesktopGuestLayout from "@js/Layouts/DesktopGuestLayout.vue";
import { computed, onMounted, onUnmounted, ref } from "vue";

defineProps<{
    title: string;
}>();

const width = ref(window.innerWidth);

const updateWidth = () => {
    width.value = window.innerWidth;
};

onMounted(() => {
    window.addEventListener("resize", updateWidth);
});

onUnmounted(() => {
    window.removeEventListener("resize", updateWidth);
});

const currentLayout = computed(()=> {
    if(width.value >= 1024) return DesktopGuestLayout;
    return MobileGuestLayout;
})

</script>

<template>
    <Head :title="title" />
    <component :is="currentLayout">
        <slot />
    </component>
</template>
