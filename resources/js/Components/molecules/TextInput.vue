<script setup lang="ts">
import InputText from "primevue/inputtext";

defineProps<{
    name: string;
    type: string;
    modelValue: string;
    modelError?: string;
    required?: boolean;
    autofocus?: boolean;
    autocomplete?: string;
}>();

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target) {
        emit("update:modelValue", target.value);
    }
};

const sanitizeName = (name: string) => {
    return (name.charAt(0).toUpperCase() + name.slice(1)).replace(/[-_]/g, " ");
};
</script>

<template>
    <div>
        <label :for="name">{{ sanitizeName(name) }}</label>
        <InputText
            :id="name"
            :type="type"
            :value="modelValue"
            :required="required"
            :autofocus="autofocus"
            :autocomplete="autocomplete"
            @input="updateValue"
            class="input"
            :invalid="!!modelError"
        />
        <small v-if="modelError" class="text-red-600">{{ modelError }}</small>
    </div>
</template>

<style scoped>
.input {
    @apply mt-1 block w-full;
}

.input:hover {
    @apply border-primary;
}
</style>
