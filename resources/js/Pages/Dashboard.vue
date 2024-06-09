<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import "@egjs/vue3-flicking/dist/flicking.css";
import useWindowWidth from "@js/hooks/useScreenWidth";
import HomePage from "@js/Components/organisms/HomePage.vue";
import SecondaryHomePage from "@js/Components/organisms/SecondaryHomePage.vue";

const width = useWindowWidth();
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <HomePage />
        <SecondaryHomePage v-if="width >= 1024" />
    </AuthenticatedLayout>
</template>
