<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import TransfersTable from "@js/Components/organisms/TransfersTable.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import { usePage } from "@inertiajs/vue3";
import { HistoryProps } from "@js/types/interfaces";

const { history } = usePage().props as Partial<HistoryProps>;

console.log(history);
</script>

<template>
    <AuthenticatedLayout title="History">
        <div class="history-wrapper">
            <SectionHeader value="History" />
            <TransfersTable :rows="7" class="py-3" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.history-wrapper {
    @apply flex flex-col mx-6 w-full;
}
</style>
