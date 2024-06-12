<script setup lang="ts">
import { SpendsByCategories } from "@js/types/types";
import { ref, onMounted } from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps<{
    spends?: SpendsByCategories;
}>();

const spendsValues = ref<number[]>([]);
const spendsLabels = ref<string[]>([]);

const createSpendsArray = (spends: SpendsByCategories) => {
    for (const [key, value] of Object.entries(spends)) {
        if (value != "0.00") {
            spendsLabels.value.push(key);
            spendsValues.value.push(parseFloat(value));
        }
    }
};

onMounted(() => {
    if (props.spends) createSpendsArray(props.spends);
});

const ApexChart = VueApexCharts;

const series = ref(spendsValues);
const chartOptions = ref({
    chart: {
        width: 380,
        type: "polarArea",
    },
    labels: spendsLabels,
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
