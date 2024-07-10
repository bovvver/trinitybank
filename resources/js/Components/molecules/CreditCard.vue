<script setup lang="ts">
import { ref } from "vue";

const props = defineProps<{
    cardNumber: string;
    balance: string;
    currency: string;
    grabable?: boolean;
    large?: boolean;
    button?: string;
    secondButton?: string;
}>();

const isGrabbing = ref(false);

const handleMouseDown = () => {
    if (props.grabable) isGrabbing.value = true;
};

const handleMouseUp = () => {
    if (props.grabable) isGrabbing.value = false;
};
</script>

<template>
    <div
        class="credit-card"
        :class="{ grabbing: isGrabbing, grabable: grabable, large: large }"
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
        <div class="credit-card__buttons">
            <button>{{ button ?? "Transfer" }}</button>
            <button v-if="secondButton">{{ secondButton }}</button>
        </div>
    </div>
</template>

<style scoped lang="scss">
.credit-card {
    @apply relative bg-primary rounded-lg p-6 text-white min-w-[400px] w-[400px] min-h-[250px] bg-[#3d87ff] bg-cover bg-card-blue
    shadow-lg shadow-gray-600;

    &.grabbing {
        @apply cursor-grabbing;
    }

    &.grabable {
        @apply cursor-grab;
    }

    &.large {
        @apply min-h-[400px] w-[700px];
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

    &__buttons {
        @apply absolute bottom-0 right-0 mr-6 mb-6 flex flex-row-reverse gap-2;

        button {
            @apply bg-white text-primary px-4 py-1 rounded font-bold shadow-sm shadow-gray-500 hover:bg-primary hover:text-white transition-colors;
        }
    }
}
</style>
