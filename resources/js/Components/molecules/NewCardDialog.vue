<script setup lang="ts">
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import BankingProduct from "@js/enums/BankingProduct";
import SelectButton from "primevue/selectbutton";
import Dropdown from "primevue/dropdown";
import Divider from "primevue/divider";
import { ref } from "vue";
import { PersonalData } from "@js/types/interfaces";
import { NewCardDropdownOptions } from "@js/types/interfaces";
import { createNewCard } from "@js/api/DataService";
import { router } from "@inertiajs/vue3";
import { showToast } from "@js/helpers/helpers";
import { useToast } from "primevue/usetoast";
import { currencyOptions } from "@js/helpers/helpers";

defineProps<{
    visible: boolean;
    data?: PersonalData;
}>();

const toast = useToast();

const emit = defineEmits(["update:visible"]);

const updateVisible = (value: boolean) => {
    emit("update:visible", value);
};

const options = ref<BankingProduct>(BankingProduct.Personal);
const selectedCurrency = ref<NewCardDropdownOptions | null>(null);

const submit = async () => {
    if (selectedCurrency.value) {
        await createNewCard(options.value, selectedCurrency.value.value).then(
            (res) =>
                router.visit(route("dashboard"), {
                    onSuccess: () => {
                        showToast(
                            toast,
                            "success",
                            "Success",
                            res.data.message
                        );
                    },
                })
        );
    }
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
                <div v-if="data">
                    <h2 class="new-card-dialog__subtitle">Your data</h2>
                    <p>{{ data.fullName }}</p>
                    <p>{{ data.ssnNumber }}</p>
                    <p>{{ data.street }}</p>
                    <p>{{ data.city }}</p>
                    <p>{{ data.zipCode }}</p>
                    <h2 class="new-card-dialog__subtitle mt-6">Contact</h2>
                    <p>{{ data.email }}</p>
                    <p>{{ data.phoneNumber }}</p>
                </div>
                <Divider v-if="data" layout="vertical" />
                <div>
                    <h2 class="new-card-dialog__subtitle">Card Details</h2>
                    <SelectButton
                        v-model="options"
                        :options="[
                            BankingProduct.Personal,
                            BankingProduct.Company,
                        ]"
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
