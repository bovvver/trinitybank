<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import "@egjs/vue3-flicking/dist/flicking.css";
import useWindowWidth from "@js/hooks/useScreenWidth";
import HomePage from "@js/Components/organisms/HomePage.vue";
import SecondaryHomePage from "@js/Components/organisms/SecondaryHomePage.vue";
import { usePage } from "@inertiajs/vue3";
import { PageProps } from "@js/types/types";
import { useDashboardStore } from "@js/stores/dashboard";
import { onMounted } from "vue";

const { accountsData, cards } = usePage().props as Partial<PageProps>;

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
        <HomePage />
        <SecondaryHomePage v-if="width >= 1024" />
    </AuthenticatedLayout>
</template>
