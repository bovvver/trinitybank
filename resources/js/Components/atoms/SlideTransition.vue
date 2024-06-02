<script setup>
import { Transition } from "vue";
</script>

<template>
    <Transition name="slide-fade" mode="out-in">
        <slot />
    </Transition>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.5s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
