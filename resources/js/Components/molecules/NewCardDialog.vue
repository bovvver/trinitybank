<script setup lang="ts">
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import BankingProduct from "@js/enums/BankingProduct";
import SelectButton from "primevue/selectbutton";
import { useForm } from "@inertiajs/vue3";
import Dropdown from "primevue/dropdown";
import Divider from "primevue/divider";
import { Currency } from "@js/enums/Currency";
import { computed, ref, watch } from "vue";
import { NewCardDetails } from "@js/types/interfaces";
import { NewCardDropdownOptions } from "@js/types/interfaces";

defineProps<{
    visible: boolean;
}>();

const form = useForm<NewCardDetails>({
    currency: null,
    banking_product: BankingProduct.Personal,
});

const emit = defineEmits(["update:visible"]);

const currencyOptions: NewCardDropdownOptions[] = Object.entries(Currency).map(
    ([name, sign]) => ({
        name: `${name} (${sign})`,
        value: name,
    })
);

const updateVisible = (value: boolean) => {
    emit("update:visible", value);
};

const options = ref([BankingProduct.Personal, BankingProduct.Company]);
const selectedCurrency = ref<NewCardDropdownOptions | null>(null);

watch(
    () => selectedCurrency.value, (newValue) => {
        if (newValue != null) form.currency = newValue.value;
    }
);

const submit = () => {
    form.post(route(""), {
        onFinish: () => {},
    });
};
</script>

<template>
    <Dialog
        :visible="visible"
        @update:visible="updateVisible"
        modal
        header="Send an application for a new card"
        class="max-w-[32rem]"
    >
        <form @submit.prevent="submit">
            <div class="new-card-dialog__wrapper">
                <div>
                    <h2 class="new-card-dialog__subtitle">Your data</h2>
                    <p>Andreane King</p>
                    <p>760-21-0047</p>
                    <p>Cummerata Drives 247</p>
                    <p>North Viviennemouth</p>
                    <p>71821-5003</p>
                    <h2 class="new-card-dialog__subtitle mt-6">Contact</h2>
                    <p>louie.gleason@example.com</p>
                    <p>(038) 326-7103</p>
                </div>
                <Divider layout="vertical" />
                <div>
                    <h2 class="new-card-dialog__subtitle">Card Details</h2>
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
            </div>
            <div class="new-card-dialog__buttons">
                <Button
                    type="button"
                    label="Cancel"
                    @click="emit('update:visible')"
                    severity="secondary"
                />
                <Button
                    type="submit"
                    label="Send"
                    @click="emit('update:visible')"
                    :disabled="selectedCurrency == null"
                />
            </div>
        </form>
    </Dialog>
</template>

<style scoped lang="scss">
.new-card-dialog {
    @apply max-w-[32rem];

    &__wrapper {
        @apply flex justify-between;
    }

    &__subtitle {
        @apply font-bold text-lg;
    }

    &__buttons {
        @apply flex justify-end gap-2;
    }
}
</style>
