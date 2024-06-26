<script setup lang="ts">
import Dropdown from "primevue/dropdown";
import { ref } from "vue";

const cards = ref([
    { number: "1234" },
    { number: "5678" },
    { number: "9012" },
    { number: "3456" },
]);
</script>

<template>
    <div class="card-list-mobile">
        <Dropdown
            :options="cards"
            optionLabel="name"
            placeholder="Select a Card"
            class="card-list-mobile__dropdown"
        >
            <template #value="slotProps">
                <div v-if="slotProps.value" class="flex items-center">
                    <i class="mr-2 pi pi-credit-card" />
                    <div>{{ slotProps.value.name }}</div>
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <div class="flex items-center">
                    <i class="mr-2 pi pi-credit-card" />
                    <div>{{ slotProps.option.name }}</div>
                </div>
            </template>
        </Dropdown>
    </div>
</template>

<style scoped lang="scss">
.card-list-mobile {
    @apply w-full flex justify-center;

    &__dropdown {
        @apply w-[80%] md:w-[50%] my-10;
    }
}
</style>
