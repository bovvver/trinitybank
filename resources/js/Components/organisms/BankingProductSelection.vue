<script setup lang="ts">
import BankingProduct from "@js/enums/BankingProduct";
import { RegistrationForm } from "@js/types/interfaces";
import SelectButton from "primevue/selectbutton";
import { ref } from "vue";

const options = ref([BankingProduct.Personal, BankingProduct.Company]);

defineProps<{
    form: RegistrationForm;
}>();
</script>

<template>
    <SelectButton v-model="form.banking_product" :options="options" aria-labelledby="basic" class="my-5 text-center" />
</template>
