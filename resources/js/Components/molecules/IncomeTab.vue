<script setup lang="ts">
import IncomeCell from "@js/Components/atoms/IncomeCell.vue";
import { Income } from "@js/types/types";

defineProps<{
    incomes?: Income;
}>();
</script>

<template>
    <div class="income_tab">
        <IncomeCell title="Daily income" :amount="incomes?.todayIncome" icon="arrow-trend-up" :isPositive="true" />
        <IncomeCell
            title="Monthly income"
            :amount="incomes?.monthIncome"
            icon="arrow-trend-up"
            :isPositive="true"
        />
        <IncomeCell
            title="Monthly spent"
            :amount="incomes?.monthSpend"
            icon="arrow-trend-down"
            :isPositive="false"
        />
    </div>
</template>

<style scoped>
.income_tab {
    @apply pt-2 flex flex-col gap-2 min-w-[160px];
}
</style>
