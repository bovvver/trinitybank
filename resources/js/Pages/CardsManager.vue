<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import Button from "primevue/button";
import CardCustomizer from "@js/Components/organisms/CardCustomizer.vue";
import CardListDropdown from "@js/Components/organisms/CardListDropdown.vue";
import CardListDesktop from "@js/Components/organisms/CardListDesktop.vue";
import NewCardDialog from "@js/Components/molecules/NewCardDialog.vue";
import useWindowWidth from "@js/hooks/useScreenWidth";
import { ref } from "vue";

const width = useWindowWidth();
const selectedCard = ref(null);
const visible = ref(false);

const updateVisible = (value: boolean) => {
    visible.value = value;
};
</script>

<template>
    <AuthenticatedLayout title="Cards">
        <div class="cards-manager">
            <div>
                <SectionHeader value="Cards" />
                <Button
                    label="New card"
                    @click="updateVisible(true)"
                    icon="pi pi-plus"
                    class="mx-3 my-2"
                />
            </div>
            <div class="cards-manager__content">
                <CardListDesktop v-if="width >= 1280" />
                <CardCustomizer class="w-[70%]" />
                <CardListDropdown
                    v-model="selectedCard"
                    v-if="width < 1280"
                    class="cards-manager__dropdown"
                />
            </div>
        </div>
        <NewCardDialog
            :visible="visible"
            @close="updateVisible(false)"
            @update:visible="updateVisible"
        />
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.cards-manager {
    @apply flex flex-col w-full h-screen;

    &__content {
        @apply flex flex-col items-center xl:flex-row xl:flex-1 xl:mt-3 xl:ml-3 xl:items-stretch;
        overflow: hidden;
    }

    &__dropdown {
        @apply my-10 w-[80%] md:w-[50%] flex justify-center;
    }
}
</style>
