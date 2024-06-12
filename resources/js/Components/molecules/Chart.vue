<script setup lang="ts">
import { DashboardStats } from "@js/types/types";
import { onMounted, ref } from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps<{
    statistics?: DashboardStats[];
}>();

const spends = ref<number[]>([]);
const incomes = ref<number[]>([]);
const labels = ref<string[]>([]);

const prepareChart = () => {
    if (!props.statistics) return;

    spends.value = props.statistics.map((el) =>
        typeof el.spends === "string" ? parseFloat(el.spends) : el.spends
    );
    incomes.value = props.statistics.map((el) =>
        typeof el.incomes === "string" ? parseFloat(el.incomes) : el.incomes
    );
    labels.value = props.statistics.map((el) => el.month);
};

onMounted(() => prepareChart());

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
        categories: labels,
    },
});

const series = ref([
    {
        name: "Income",
        data: incomes,
        color: "#3b82f6",
    },
    {
        name: "Spent",
        data: spends,
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
