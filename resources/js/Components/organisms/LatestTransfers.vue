<script setup lang="ts">
import TransferCell from "@js/Components/molecules/TransferCell.vue";
import { getDateDaysAgo } from "@js/helpers/helpers";
import { ref } from "vue";

const transfers = ref([
    {
        name: "John Doe",
        description: "May Payout",
        amount: 5000,
        date: new Date(),
    },
    {
        name: "Mary Jane",
        description: "Sorry for that flowerpot...",
        amount: -25,
        date: getDateDaysAgo(2),
    },
    {
        name: "Spotify",
        description: "Monthly Subscription",
        amount: -11.99,
        date: getDateDaysAgo(5),
    },
    {
        name: "Bill Smith",
        description: "Dinner",
        amount: 50,
        date: getDateDaysAgo(9),
    },
]);
</script>

<template>
    <div class="transfers-wrapper">
        <TransferCell
            v-for="transfer in transfers"
            :amount="transfer.amount"
            :description="transfer.description"
            :name="transfer.name"
            :date="transfer.date"
        />
        <button class="transfers-wrapper__button">More transfers</button>
    </div>
</template>

<style scoped lang="scss">
.transfers-wrapper {
    @apply mx-6 bg-gray-100 rounded-b-3xl rounded-t-xl;

    &__button {
        @apply w-full mt-3 py-3 text-white font-bold bg-gradient-to-r from-neutral-950 to-primary-500 rounded-full shadow-lg shadow-gray-500;
    }
}
</style>
