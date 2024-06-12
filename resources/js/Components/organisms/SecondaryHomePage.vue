<script setup lang="ts">
import Chart from "@js/Components/molecules/Chart.vue";
import PieChart from "@js/Components/molecules/PieChart.vue";
import IncomeTab from "@js/Components/molecules/IncomeTab.vue";
import { Income, SpendsByCategories } from "@js/types/types";

defineProps<{
    incomes?: Income;
    spendsByCategories?: SpendsByCategories;
}>();
</script>

<template>
    <div class="secondary-wrapper">
        <Chart />
        <div class="secondary-wrapper__stats">
            <IncomeTab :incomes="incomes"/>
            <PieChart class="secondary-wrapper__stats-chart" :spends="spendsByCategories" />
        </div>
    </div>
</template>

<style scoped lang="scss">
.secondary-wrapper {
    @apply w-full m-6;

    &__stats {
        @apply flex justify-center items-start;

        &-chart {
            @apply w-full;
        }
    }
}
</style>
