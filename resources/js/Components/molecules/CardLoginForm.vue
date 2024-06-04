<script setup lang="ts">
import InputNumber from "primevue/inputnumber";
import { CardLoginForm } from "@js/types/types";
import Calendar from "primevue/calendar";

defineProps<{
    form: CardLoginForm;
}>();
</script>

<template>
    <div>
        <div>
            <label for="cvv_number">CVV Number</label>
            <InputNumber
                v-model="form.cvv_number"
                inputId="cvv_number"
                :min="100"
                :max="999"
                required
                class="mt-1 block w-full"
                :invalid="!!form.errors.cvv_number"
            />
            <small v-if="form.errors.cvv_number" class="text-red-600">{{
                form.errors.cvv_number
            }}</small>
        </div>
        <div class="mt-4">
            <label for="expiry_date">Expiry Date</label>
            <Calendar
                v-model="form.expiry_date"
                view="month"
                dateFormat="mm/y"
                required
                class="mt-1 block w-full"
                :invalid="!!form.errors.expiry_date"
            />
            <small v-if="form.errors.expiry_date" class="text-red-600">{{
                form.errors.expiry_date
            }}</small>
        </div>
    </div>
</template>
