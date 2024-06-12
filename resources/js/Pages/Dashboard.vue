<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import "@egjs/vue3-flicking/dist/flicking.css";
import useWindowWidth from "@js/hooks/useScreenWidth";
import HomePage from "@js/Components/organisms/HomePage.vue";
import SecondaryHomePage from "@js/Components/organisms/SecondaryHomePage.vue";
import { usePage } from "@inertiajs/vue3";
import { PageProps } from "@js/types/types";

const { transfers, favourites, incomes, spendsByCategories, statistics } = usePage()
    .props as Partial<PageProps>;

const width = useWindowWidth();
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <HomePage :transfers="transfers" :favourites="favourites" />
        <SecondaryHomePage
            v-if="width >= 1024"
            :incomes="incomes"
            :spendsByCategories="spendsByCategories"
            :statistics="statistics"
        />
    </AuthenticatedLayout>
</template>
