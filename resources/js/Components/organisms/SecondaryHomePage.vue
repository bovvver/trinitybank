<script setup lang="ts">
import Chart from "@js/Components/molecules/Chart.vue";
import PieChart from "@js/Components/molecules/PieChart.vue";
import IncomeTab from "@js/Components/molecules/IncomeTab.vue";
</script>

<template>
    <div class="secondary-wrapper">
        <Chart />
        <div class="secondary-wrapper__stats">
            <IncomeTab />
            <PieChart class="secondary-wrapper__stats-chart" />
        </div>
    </div>
</template>

<style scoped lang="scss">
.secondary-wrapper {
    @apply w-full m-6 lg:max-w-[40%] xl:max-w-[50%];

    &__stats {
        @apply flex justify-center items-start h-max;

        &-chart {
            @apply w-full;
        }
    }
}
</style>
