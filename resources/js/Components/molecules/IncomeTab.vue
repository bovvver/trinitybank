<script setup lang="ts">
import IncomeCell from "@js/Components/atoms/IncomeCell.vue";
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";
import { ref, watch } from "vue";

const dashboardStore = useDashboardStore();
const { incomes, transfers } = storeToRefs(dashboardStore);

const currency = ref("");

watch(transfers, (newTransfers) => {
    if (newTransfers.length > 0 && newTransfers[0].currency) {
        currency.value = newTransfers[0].currency;
    }
}, { immediate: true });
</script>

<template>
    <div class="income_tab">
        <IncomeCell
            title="Daily income"
            :amount="incomes?.todayIncome"
            icon="arrow-trend-up"
            :isPositive="true"
            :currency="currency"
        />
        <IncomeCell
            title="Monthly income"
            :amount="incomes?.monthIncome"
            icon="arrow-trend-up"
            :isPositive="true"
            :currency="currency"
        />
        <IncomeCell
            title="Monthly spent"
            :amount="incomes?.monthSpend"
            icon="arrow-trend-down"
            :isPositive="false"
            :currency="currency"
        />
    </div>
</template>

<style scoped>
.income_tab {
    @apply pt-2 flex flex-col gap-2 min-w-[160px];
}
</style>
