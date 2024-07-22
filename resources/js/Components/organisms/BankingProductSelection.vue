<script setup lang="ts">
import BankingProduct from "@js/enums/BankingProduct";
import { NewCardDropdownOptions, RegistrationForm } from "@js/types/interfaces";
import SelectButton from "primevue/selectbutton";
import Dropdown from "primevue/dropdown";
import { currencyOptions } from "@js/helpers/helpers";
import { ref, watch } from "vue";

const props = defineProps<{
    form: RegistrationForm;
}>();

const selectedCurrency = ref<NewCardDropdownOptions | null>(null);
const options = ref([BankingProduct.Personal, BankingProduct.Company]);

watch(
    () => selectedCurrency.value,
    () => {
        if (selectedCurrency.value)
            props.form.currency = selectedCurrency.value.value;
    }
);
</script>

<template>
    <div>
        <SelectButton
            v-model="form.banking_product"
            :options="options"
            aria-labelledby="basic"
            class="my-5 text-center"
        />
        <Dropdown
            v-model="selectedCurrency"
            :options="currencyOptions"
            optionLabel="name"
            placeholder="Select a Currency"
            filter
            class="w-full"
        />
    </div>
</template>
