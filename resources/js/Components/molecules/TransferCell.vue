<script setup lang="ts">
import Avatar from "primevue/avatar";
import { formatDate, displayCorrectAmount } from "@js/helpers/helpers";
import { Currency } from "@js/enums/Currency";

defineProps<{
    name: string;
    message: string;
    amount: string;
    currency: keyof typeof Currency;
    date: string;
    isSender: number;
}>();
</script>

<template>
    <div class="transfer-cell">
        <Avatar size="large" :label="name.charAt(0)" shape="circle" />
        <div>
            <p class="transfer-cell__name">{{ name }}</p>
            <p class="transfer-cell__description">{{ message }}</p>
            <p
                class="transfer-cell__amount"
                :class="{ positive: !isSender, negative: isSender }"
            >
                {{ displayCorrectAmount(parseFloat(amount), isSender) }}
                <span class="transfer-cell__currency">{{ currency }}</span>
            </p>
            <p class="transfer-cell__date">{{ formatDate(new Date(date)) }}</p>
        </div>

        <div class="transfer-cell__separator" />
    </div>
</template>

<style scoped lang="scss">
.transfer-cell {
    @apply relative flex items-center gap-3 px-2 py-2;

    &__name {
        @apply text-xl font-bold text-gray-800;
    }

    &__description {
        @apply text-gray-700;
    }

    &__amount {
        @apply pr-6 absolute right-0 top-[32%] -translate-y-[50%] text-xl font-bold;
    }

    &__date {
        @apply pr-6 absolute right-0 top-[70%] -translate-y-[50%] text-base;
    }

    &__separator {
        @apply absolute bottom-0 left-[50%] w-4/5 bg-gray-300 h-[1px] -translate-x-[50%];
    }

    &__currency {
        @apply text-sm;
    }
}

.positive {
    @apply text-green-500;
}

.negative {
    @apply text-red-500;
}
</style>
