<script setup lang="ts">
import Chart from "../molecules/Chart.vue";
import IncomeTab from "../molecules/IncomeTab.vue";
</script>

<template>
    <div class="secondary-wrapper">
        <Chart />
        <div>
            <IncomeTab />
        </div>
    </div>
</template>

<style scoped>
    .secondary-wrapper {
        @apply w-full m-6;
    }
</style>