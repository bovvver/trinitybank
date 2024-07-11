<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import TransfersTable from "@js/Components/organisms/TransfersTable.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
</script>

<template>
    <AuthenticatedLayout title="History">
        <div class="history-wrapper">
            <SectionHeader value="History" />
            <TransfersTable class="py-3" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.history-wrapper {
    @apply flex flex-col mx-6 w-full;
}
</style>
