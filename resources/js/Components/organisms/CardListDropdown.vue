<script setup lang="ts">
import Dropdown, { DropdownChangeEvent } from "primevue/dropdown";
import { ref, watch } from "vue";

const props = defineProps<{
    modelValue: string | null;
}>();

const emit = defineEmits(["update:modelValue"]);

const cards = ref([
    { number: "1234" },
    { number: "5678" },
    { number: "9012" },
    { number: "3456" },
]);

const dropdownValue = ref(props.modelValue);

const updateValue = (event: DropdownChangeEvent) => {
    if (event) emit("update:modelValue", event.value);
};

watch(() => props.modelValue, (newValue) => {
    dropdownValue.value = newValue;
});
</script>

<template>
    <div class="card-list">
        <Dropdown
            v-model="dropdownValue"
            :options="cards"
            optionLabel="number"
            placeholder="Select a Card"
            class="w-full"
            @change="updateValue"
        >
            <template #value="slotProps">
                <div v-if="slotProps.value" class="flex items-center">
                    <i class="mr-2 pi pi-credit-card" />
                    <div>**** {{ slotProps.value.number }}</div>
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <div class="flex items-center">
                    <i class="mr-2 pi pi-credit-card" />
                    <div>**** {{ slotProps.option.number }}</div>
                </div>
            </template>
        </Dropdown>
    </div>
</template>

<style scoped lang="scss">
.card-list {
    @apply w-full flex justify-center;
}
</style>
