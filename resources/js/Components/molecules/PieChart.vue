<script setup lang="ts">
import { ref } from "vue";
import VueApexCharts from "vue3-apexcharts";

const ApexChart = VueApexCharts;

const series = ref([42, 47, 52, 58, 65]);
const chartOptions = ref({
    chart: {
        width: 380,
        type: "polarArea",
    },
    labels: ["Education", "Food", "Hygiene", "Transport", "Investments"],
    fill: {
        opacity: 1,
    },
    stroke: {
        width: 1,
        colors: undefined,
    },
    yaxis: {
        show: false,
    },
    legend: {
        position: "top",
        labels: {
            colors: "#fff",
        },
    },
    plotOptions: {
        polarArea: {
            rings: {
                strokeWidth: 0,
            },
            spokes: {
                strokeWidth: 0,
            },
        },
    },
    theme: {
        monochrome: {
            enabled: true,
            shadeTo: "light",
            shadeIntensity: 0.6,
        },
    },
});
</script>

<template>
    <div class="chart">
        <ApexChart
            type="polarArea"
            :options="chartOptions"
            :series="series"
            :height="485"
            class="text-white"
        />
    </div>
</template>

<style scoped lang="scss">
.chart {
    @apply m-3 bg-neutral-900 rounded-lg;

    &__title {
        @apply font-bold text-xl pl-6;
    }
}
</style>
