<script setup lang="ts">
import { displayCorrectAmount } from "@js/helpers/helpers";

defineProps<{
    title: string;
    icon: string;
    isPositive: boolean;
    currency: string;
    amount?: string;
}>();
</script>

<template>
    <div
        class="cell-wrapper"
        :class="{ positive: isPositive, negative: !isPositive }"
    >
        <p class="cell-wrapper__amount">{{ displayCorrectAmount(parseFloat(amount ?? "0"), isPositive) }}</p>
        <p class="cell-wrapper__title">{{ title }} <span v-if="currency">({{ currency }})</span></p>
        <font-awesome-icon :icon="['fas', icon]" class="cell-wrapper__icon" />
    </div>
</template>

<style scoped lang="scss">
.cell-wrapper {
    @apply relative p-3 rounded-3xl max-w-[160px] aspect-square flex flex-col items-center justify-center;

    &__amount {
        @apply font-bold text-3xl;
    }

    &__title {
        @apply text-sm text-center;
    }

    &__icon {
        @apply absolute text-8xl text-neutral-900/[.50] z-[-10];
    }
}

.positive {
    @apply bg-gradient-to-r from-green-500/[.72] to-green-300/[.72];
}

.negative {
    @apply bg-gradient-to-r from-red-500/[.72] to-red-300/[.72];
}
</style>
