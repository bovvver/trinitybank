<script setup>
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="wrapper">
        <div class="form">
            <Link :href="route('index')">
                <ApplicationLogo :size="120" />
            </Link>
            <slot />
        </div>
        <div class="welcome">
            <h2>Empowering Your Financial Future.</h2>
            <p>Discover seamless banking solutions designed to help you achieve your goals with ease and confidence.</p>
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    @apply min-h-screen bg-welcome-background bg-cover bg-center flex flex-row;
}

.form {
    @apply flex flex-col items-center justify-center w-3/6 xl:w-2/5 2xl:w-1/4 bg-gray-200;
}

.welcome {
    @apply px-10 py-40 w-3/6 xl:w-3/5 2xl:w-3/4 flex flex-col justify-start items-start bg-black/[.70];
}

.welcome h2 {
    @apply text-white font-bold text-8xl;
}

.welcome p {
    @apply text-white text-3xl;
}
</style>
