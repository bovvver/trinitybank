<script setup lang="ts">
import CreditCard from "../molecules/CreditCard.vue";
import { DashboardCards } from "@js/types/interfaces";

defineProps<{
    cards: DashboardCards[];
}>();

</script>

<template>
    <div class="card-list-desktop">
        <div class="card-list-desktop__scroll">
            <CreditCard
                v-for="card in cards"
                :key="card.cardLastDigits"
                :cardNumber="card.cardLastDigits"
                :balance="card.balance"
                :currency="card.currency"
                button="Select"
                :cardColor="card.cardColor"
            />
        </div>
    </div>
</template>

<style scoped lang="scss">
.card-list-desktop {
    @apply flex-1 flex;

    &__scroll {
        @apply flex flex-col gap-6 overflow-y-scroll transition-[scrollbar-color];
        width: 100%;

        &::-webkit-scrollbar {
            width: 8px;
            height: 8px;
            background-color: transparent;
        }

        &::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5);
        }

        &::-webkit-scrollbar-track {
            background-color: transparent;
        }

        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.5) transparent;
        direction: rtl;
        text-align: left;

        &:hover {
            scrollbar-color: rgba(117, 117, 117, 0.5) transparent;
        }
    }
}

.card-list-desktop__scroll > * {
    direction: ltr;
}
</style>
