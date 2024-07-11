<script setup lang="ts">
import TransferCell from "@js/Components/molecules/TransferCell.vue";
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";
import { Link } from "@inertiajs/vue3";

const dashboardStore = useDashboardStore();
const { transfers } = storeToRefs(dashboardStore);
</script>

<template>
    <div class="transfers-wrapper">
        <TransferCell
            v-for="transfer in transfers"
            :amount="transfer.amount"
            :currency="transfer.currency"
            :message="transfer.message"
            :name="transfer.fullName"
            :date="transfer.transactionDate"
            :isSender="transfer.isSender"
        />
        <Link :href="route('history')">
            <button class="transfers-wrapper__button">More transfers</button>
        </Link>
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
