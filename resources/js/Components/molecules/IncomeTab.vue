<script setup lang="ts">
import IncomeCell from "@js/Components/atoms/IncomeCell.vue";
</script>

<template>
    <div class="income_tab">
        <IncomeCell title="Daily income" :amount="5000" icon="arrow-trend-up" />
        <IncomeCell title="Monthly income" :amount="6243" icon="arrow-trend-up" />
        <IncomeCell title="Monthly spent" :amount="-3300" icon="arrow-trend-down" />
    </div>
</template>

<style scoped>
.income_tab {
    @apply pt-2 flex flex-col gap-2 min-w-[160px];
}
</style>
