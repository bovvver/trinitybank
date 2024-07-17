<script setup lang="ts">
import Dropdown, { DropdownChangeEvent } from "primevue/dropdown";
import { ref, watch } from "vue";

const props = defineProps<{
    modelValue: string;
}>();

const categories = [
    "Education",
    "Food",
    "Hygiene",
    "Transport",
    "Work",
    "Investments",
    "Others",
];

const emit = defineEmits(["update:modelValue"]);

const dropdownValue = ref(props.modelValue);

const updateValue = (event: DropdownChangeEvent) => {
    if (event) emit("update:modelValue", event.value);
};

watch(() => props.modelValue,
    (newValue) => {dropdownValue.value = newValue;}
);
</script>

<template>
    <div>
        <Dropdown
            v-model="dropdownValue"
            :options="categories"
            class="w-full"
            @change="updateValue"
        >
            <template #value="slotProps">
                <div v-if="slotProps.value">
                    <div>{{ slotProps.value }}</div>
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <div>{{ slotProps.option }}</div>
            </template>
        </Dropdown>
    </div>
</template>