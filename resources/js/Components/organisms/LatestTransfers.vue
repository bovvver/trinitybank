<script setup lang="ts">
import TransferCell from "@js/Components/molecules/TransferCell.vue";
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { getFinalAvatarUrl } from "@js/helpers/helpers";

const dashboardStore = useDashboardStore();
const { transfers } = storeToRefs(dashboardStore);

const transfersButtonMessage = computed(() => {
    return transfers.value.length === 0
        ? "No transfers recently"
        : "More transfers";
});

const avatarUrls = computed(() => {
    return transfers.value.map((transfer) => {
        if (transfer.avatarPath !== "") return getFinalAvatarUrl(transfer.avatarPath);
        return ""
    });
});
</script>

<template>
    <div class="transfers-wrapper">
        <TransferCell
            v-for="(transfer, index) in transfers"
            :key="index"
            :amount="transfer.amount"
            :currency="transfer.currency"
            :message="transfer.message"
            :name="transfer.fullName"
            :date="transfer.transactionDate"
            :isSender="transfer.isSender"
            :avatarPath="avatarUrls[index]"
        />
        <Link :href="route('history')">
            <button class="transfers-wrapper__button">
                {{ transfersButtonMessage }}
            </button>
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
