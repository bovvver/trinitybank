<script setup lang="ts">
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import Slider from "@egjs/vue3-flicking";
import "@egjs/vue3-flicking/dist/flicking.css";
import Favourites from "@js/Components/molecules/Favourites.vue";
import LatestTransfers from "@js/Components/organisms/LatestTransfers.vue";
import { ref } from "vue";
import { Transfer, FavouriteAccount, Income, SpendsByCategories } from "@js/types/types";

defineProps<{
    transfers?: Transfer[];
    favourites?: FavouriteAccount[];
}>();

const cards = ref([
    {
        cardNumber: "**** 3385",
        balance: 9773.84,
    },
    {
        cardNumber: "**** 4532",
        balance: 7456.53,
    },
]);
</script>

<template>
    <div class="home-wrapper">
        <SectionHeader value="Home" class="mx-6" />
        <Slider :options="{ renderOnlyVisible: true }" class="py-6">
            <CreditCard
                v-for="(card, idx) in cards"
                :key="idx"
                :cardNumber="card.cardNumber"
                :balance="card.balance"
                class="mx-6"
            />
        </Slider>
        <Favourites />
        <LatestTransfers :transfers="transfers ?? []" />
    </div>
</template>

<style scoped>
.home-wrapper {
    @apply h-full lg:max-w-[40%] xl:max-w-[30%] flex flex-col;
}
</style>
