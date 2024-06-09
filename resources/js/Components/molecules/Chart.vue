<script setup lang="ts">
import { ref } from "vue";
import VueApexCharts from "vue3-apexcharts";

const ApexChart = VueApexCharts;

const chartOptions = ref({
    chart: {
        type: "bar",
    },
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 10,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["#fff"],
    },
    tooltip: {
        shared: true,
        intersect: false,
    },
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
    },
});

const series = ref([
    {
        name: "Income",
        data: [4400, 5500, 4100, 6400, 2200, 4300],
        color: "#3b82f6",
    },
    {
        name: "Spent",
        data: [5300, 3200, 3300, 5200, 1300, 4400],
        color: "#101010",
    },
]);
</script>

<template>
    <div class="chart">
        <h2 class="chart__title">Statistics</h2>
        <ApexChart
            type="bar"
            :height="230"
            :options="chartOptions"
            :series="series"
        />
    </div>
</template>

<style scoped lang="scss">
.chart {
    @apply p-3 bg-surface-100 rounded-md max-h-[350px];

    &__title {
        @apply font-bold text-xl pl-6;
    }
}
</style>
