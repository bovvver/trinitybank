<script setup lang="ts">
import { ref } from "vue";

defineProps<{
    cardNumber: string;
    balance: string;
    currency: string;
}>();

const isGrabbing = ref(false);

const handleMouseDown = () => {
    isGrabbing.value = true;
};

const handleMouseUp = () => {
    isGrabbing.value = false;
};
</script>

<template>
    <div
        class="credit-card"
        :class="{ grabbing: isGrabbing }"
        @mousedown="handleMouseDown"
        @mouseup="handleMouseUp"
        @mouseleave="handleMouseUp"
        @touchstart="handleMouseDown"
        @touchend="handleMouseUp"
    >
        <font-awesome-icon
            :icon="['fas', 'piggy-bank']"
            class="absolute text-black right-0 pr-6 text-2xl"
        />
        <p class="credit-card__number">**** {{ cardNumber }}</p>
        <p class="credit-card__header">Balance</p>
        <p class="credit-card__balance">
            <span class="credit-card__balance-currency">{{ currency }}</span>
            {{ balance }}
        </p>
        <button class="credit-card__button">Transfer</button>
    </div>
</template>

<style scoped lang="scss">
.credit-card {
    @apply relative bg-primary rounded-lg p-6 text-white min-w-[400px] min-h-[250px] bg-[#3d87ff] bg-cover bg-card-blue
    shadow-lg shadow-gray-600 cursor-grab;

    &.grabbing {
        @apply cursor-grabbing;
    }

    &__number {
        @apply absolute left-0 pl-6;
    }

    &__header {
        @apply absolute font-bold text-lg top-[30%] left-0 pl-6;
    }

    &__balance {
        @apply absolute font-bold text-3xl top-[39%] left-0 pl-6;

        &-currency {
            @apply text-sm;
        }
    }

    &__button {
        @apply absolute bottom-0 right-0 bg-white text-primary px-4 py-1 rounded font-bold mr-6 mb-6 shadow-sm shadow-gray-500 hover:bg-primary hover:text-white transition-colors;
    }
}
</style>
