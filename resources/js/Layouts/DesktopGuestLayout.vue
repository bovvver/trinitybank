<script setup>
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="desktop-guest-layout">
        <div class="desktop-guest-layout__form">
            <Link :href="route('index')">
                <ApplicationLogo :size="120" />
            </Link>
            <slot />
        </div>
        <div class="desktop-guest-layout__welcome">
            <h2>Empowering Your Financial Future.</h2>
            <p>
                Discover seamless banking solutions designed to help you achieve
                your goals with ease and confidence.
            </p>
        </div>
    </div>
</template>

<style scoped lang="scss">
.desktop-guest-layout {
    @apply min-h-screen bg-welcome-background bg-cover bg-center flex flex-row;

    &__form {
        @apply flex flex-col items-center justify-center w-3/6 xl:w-2/5 2xl:w-1/4 bg-gray-200;
    }

    &__welcome {
        @apply px-10 py-40 w-3/6 xl:w-3/5 2xl:w-3/4 flex flex-col justify-start items-start bg-black/[.70];

        h2 {
            @apply text-white font-bold text-8xl;
        }

        p {
            @apply text-white text-3xl;
        }
    }
}
</style>
