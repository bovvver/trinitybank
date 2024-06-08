<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import Slider from "@egjs/vue3-flicking";
import "@egjs/vue3-flicking/dist/flicking.css";
import Favourites from "@js/Components/molecules/Favourites.vue";
import LatestTransfers from "@js/Components/organisms/LatestTransfers.vue";
import { ref } from "vue";

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
    <AuthenticatedLayout title="Dashboard">
        <div class="wrapper">
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
            <LatestTransfers />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.wrapper {
    @apply h-full flex flex-col;
}
</style>
