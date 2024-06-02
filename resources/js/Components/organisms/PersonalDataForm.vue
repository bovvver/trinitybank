<script setup lang="ts">
import { RegistrationForm } from "@js/types/interfaces";
import TextInput from "@js/Components/molecules/TextInput.vue";
import InputMask from "primevue/inputmask";

defineProps<{
    form: RegistrationForm;
}>();
</script>

<template>
    <div>
        <div>
            <label for="ssn_number">SSN Number</label>
            <InputMask
                id="ssn_number"
                v-model="form.ssn_number"
                mask="999-99-9999"
                placeholder="999-99-9999"
                required
                class="input"
            />
            <small v-if="form.errors.ssn_number" class="text-red-600">{{
                form.errors.ssn_number
            }}</small>
        </div>
        <div>
            <label for="phone">Phone</label>
            <InputMask
                id="phone"
                v-model="form.phone"
                mask="(999) 999-9999"
                placeholder="(999) 999-9999"
                required
                class="input mt-4"
            />
            <small v-if="form.errors.phone" class="text-red-600">{{
                form.errors.phone
            }}</small>
        </div>

        <div class="flex flex-row gap-3 mt-4">
            <TextInput
                name="city"
                type="input"
                v-model="form.city"
                :modelError="form.errors.city"
                :required="true"
                class="w-full"
            />
            <div>
                <label for="zip_code">Zip Code</label>
                <InputMask
                    id="zip_code"
                    v-model="form.zip_code"
                    mask="99999-9999"
                    placeholder="99999-9999"
                    required
                    class="input w-full"
                />
                <small v-if="form.errors.zip_code" class="text-red-600">{{
                    form.errors.zip_code
                }}</small>
            </div>
        </div>
        <div class="flex flex-row gap-3 mt-4">
            <TextInput
                name="street"
                type="input"
                v-model="form.street"
                :modelError="form.errors.street"
                :required="true"
                class="w-full"
            />
            <TextInput
                name="house_number"
                type="input"
                v-model="form.house_number"
                :modelError="form.errors.house_number"
                :required="true"
                class="w-full"
            />
        </div>
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
