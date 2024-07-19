<script setup lang="ts">
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import useWindowWidth from "@js/hooks/useScreenWidth";
import { DashboardCards } from "@js/types/interfaces";
import { ref } from "vue";

const props = defineProps<{
    cards: DashboardCards[];
}>();

const activeCard = ref<DashboardCards>(props.cards[0]);

const width = useWindowWidth();
</script>

<template>
    <div class="card-customizer">
        <CreditCard
            :cardNumber="activeCard.cardLastDigits"
            :balance="activeCard.balance"
            :currency="activeCard.currency"
            :large="width >= 1024"
            button="Disable"
            secondButton="Save"
        />
        <div class="flex gap-2">
            <button class="card-customizer__button blue-card" />
            <button class="card-customizer__button yellow-card" />
            <button class="card-customizer__button green-card" />
            <button class="card-customizer__button black-card" />
        </div>
    </div>
</template>

<style scoped lang="scss">
.card-customizer {
    @apply w-full flex flex-col gap-5 items-center;

    &__button {
        @apply w-[70px] h-[50px] bg-cover rounded-lg border-2 border-neutral-800 hover:scale-110 hover:shadow-lg shadow-gray-600 transition-transform;
    }
}

.blue-card {
    @apply bg-card-blue bg-[#3d87ff];
}
.yellow-card {
    @apply bg-card-yellow bg-[#ffff99];
}
.green-card {
    @apply bg-card-green bg-[#00bb77];
}
.black-card {
    @apply bg-card-black bg-[#000000];
}
</style>
