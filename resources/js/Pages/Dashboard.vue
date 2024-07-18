<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import "@egjs/vue3-flicking/dist/flicking.css";
import useWindowWidth from "@js/hooks/useScreenWidth";
import HomePage from "@js/Components/organisms/HomePage.vue";
import SecondaryHomePage from "@js/Components/organisms/SecondaryHomePage.vue";
import { usePage } from "@inertiajs/vue3";
import { DashboardProps } from "@js/types/interfaces";
import { useDashboardStore } from "@js/stores/dashboard";
import { onMounted } from "vue";
import Toast from "primevue/toast";

const { accountsData, cards, selectedCard } = usePage().props as Partial<DashboardProps>;

const dashboardStore = useDashboardStore();

const prepareDashboardData = () => {
    if (!accountsData || !accountsData[0]) return;

    dashboardStore.creditCards = cards;
    dashboardStore.accountsData = accountsData;

    dashboardStore.changeStore();
};

onMounted(() => prepareDashboardData());

const width = useWindowWidth();
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <HomePage :selectedCard="selectedCard" />
        <SecondaryHomePage v-if="width >= 1024" />
        <Toast />
    </AuthenticatedLayout>
</template>
