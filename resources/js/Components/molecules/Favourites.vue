<script setup lang="ts">
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";
import Avatar from "primevue/avatar";
import { router } from "@inertiajs/vue3";

const dashboardStore = useDashboardStore();
const { favourites } = storeToRefs(dashboardStore);

const routeToTransfer = (accountNumber: string) => {
    router.visit(route("transfer", {
        target: accountNumber
    }));
};
</script>

<template>
    <div class="favourites">
        <Avatar
            v-for="favourite in favourites"
            :label="favourite.fullName.charAt(0)"
            class="favourites__avatar"
            size="xlarge"
            shape="circle"
            @click="routeToTransfer(favourite.accountNumber)"
        />
    </div>
</template>

<style scoped lang="scss">
.favourites {
    @apply mx-6 mb-5 py-4 flex justify-evenly bg-gradient-to-r from-neutral-950 to-primary-500 rounded-full shadow-lg shadow-gray-500;

    &__avatar {
        @apply cursor-pointer hover:bg-gray-400 transition-colors;
    }
}
</style>
