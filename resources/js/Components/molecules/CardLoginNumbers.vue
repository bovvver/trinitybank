<script setup lang="ts">
import InputOtp from "primevue/inputotp";
import { CardLoginForm } from "@js/types/interfaces";

defineProps<{
    form: CardLoginForm;
}>();
</script>

<template>
    <div class="flex flex-col items-center justify-center gap-3">
        <InputOtp v-model="form.card_number" integerOnly :length="4" required>
            <template #default="{ attrs, events }">
                <input
                    type="text"
                    v-bind="attrs"
                    v-on="events"
                    class="custom-otp-input"
                    required
                />
            </template>
        </InputOtp>
        <small
            >Please enter the penultimate digit of each card number
            block.</small
        >
        <small v-if="form.errors.card_number" class="text-red-600">{{
            form.errors.card_number
        }}</small>
    </div>
</template>

<style scoped>
.custom-otp-input {
    @apply w-14 text-4xl text-center border-b-2 border-gray-500 rounded-lg bg-white;
}
</style>
