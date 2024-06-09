<script setup>
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="mobile-guest-layout">
        <div class="mobile-guest-layout__content">
            <Link :href="route('index')">
                <ApplicationLogo :size="120" />
            </Link>
            <slot />
        </div>
    </div>
</template>

<style scoped lang="scss">
.mobile-guest-layout {
    @apply min-h-screen flex flex-col justify-center items-center bg-welcome-background bg-cover bg-center;

    &__content {
        @apply flex flex-col items-center justify-center w-full -translate-y-[15%];
    }
}
</style>
