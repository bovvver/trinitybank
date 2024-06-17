<script setup lang="ts">
import { SpendsByCategories } from "@js/types/interfaces";
import { ref, onMounted, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";

const dashboardStore = useDashboardStore();
const { spendsByCategories } = storeToRefs(dashboardStore);

const spendsValues = ref<number[]>([]);
const spendsLabels = ref<string[]>([]);

const createSpendsArray = (spends: SpendsByCategories) => {
    spendsValues.value = [];
    spendsLabels.value = [];

    for (const [key, value] of Object.entries(spends)) {
        if (value != "0.00") {
            spendsLabels.value.push(
                key.charAt(0).toUpperCase() + key.substring(1)
            );
            spendsValues.value.push(parseFloat(value));
        }
    }
};

onMounted(() => {
    if (spendsByCategories.value) {
        createSpendsArray(spendsByCategories.value);
    }
    watch(
        spendsByCategories,
        (newSpends) => {
            if (newSpends) {
                createSpendsArray(newSpends);
            }
        },
        { immediate: true }
    );
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
