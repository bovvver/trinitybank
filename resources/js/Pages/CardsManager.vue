<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import Button from "primevue/button";
import CardCustomizer from "@js/Components/organisms/CardCustomizer.vue";
import CardListMobile from "@js/Components/organisms/CardListMobile.vue";
import CardListDesktop from "@js/Components/organisms/CardListDesktop.vue";
import useWindowWidth from "@js/hooks/useScreenWidth";

const width = useWindowWidth();
</script>

<template>
    <AuthenticatedLayout title="Cards">
        <div class="cards-manager">
            <div>
                <SectionHeader value="Cards" />
                <Button label="New card" icon="pi pi-plus" class="mx-3 my-2" />
            </div>
            <div class="cards-manager__content">
                <CardListDesktop v-if="width >= 1280" />
                <CardCustomizer class="w-[70%]" />
                <CardListMobile v-if="width < 1280" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.cards-manager {
    @apply flex flex-col w-full h-screen;

    &__content {
        @apply flex-1 xl:flex xl:mt-3 xl:ml-3;
        overflow: hidden;
    }
}
</style>
