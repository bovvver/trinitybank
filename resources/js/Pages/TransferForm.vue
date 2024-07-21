<script setup lang="ts">
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import InputMask from "primevue/inputmask";
import InputNumber from "primevue/inputnumber";
import Button from "primevue/button";
import Calendar from "primevue/calendar";
import Dropdown from "primevue/dropdown";
import TransferInput from "@js/Components/molecules/TransferInput.vue";
import TransferInfo from "@js/Components/atoms/TransferInfo.vue";
import { computed, reactive, ref, watch } from "vue";
import Avatar from "primevue/avatar";
import useWindowWidth from "@js/hooks/useScreenWidth";
import Card from "@js/Components/atoms/Card.vue";
import CardListDropdown from "@js/Components/organisms/CardListDropdown.vue";
import CategoriesDropdown from "@js/Components/organisms/CategoriesDropdown.vue";
import {
    DashboardCards,
    DashboardFavourites,
    Errors,
    TransferProps,
    TransferFormProps,
} from "@js/types/interfaces";
import TextInput from "@js/Components/molecules/TextInput.vue";
import { showToast } from "@js/helpers/helpers";
import { makeTransfer } from "@js/api/DataService";

const { favourites, cards } = usePage().props as Partial<TransferFormProps>;

const selectedCard = ref<DashboardCards | null>(null);
const selectedReceiver = ref<DashboardFavourites | string>("");
const selectedCategory = ref("Others");

const toast = useToast();
const width = useWindowWidth();
const form = useForm<TransferProps>({
    receiver: "",
    message: "",
    category: "",
    sender_card: "",
    account_number: "",
    amount: 0,
    currency: "",
    date: "",
});

const errors: Errors = reactive({
    receiver: "",
    message: "",
    category: "",
    sender_card: "",
    account_number: "",
    amount: "",
    currency: "",
    date: "",
});

watch(
    () => selectedReceiver.value,
    (newValue) => {
        if (typeof newValue === "string") form.receiver = newValue;
        else if (newValue && typeof newValue === "object") {
            form.receiver = newValue.fullName;
            form.account_number = newValue.accountNumber;
        }
    }
);

watch(
    [() => selectedCategory.value, () => selectedCard.value],
    ([newCategoryValue, newCardValue]) => {
        if (newCategoryValue) form.category = newCategoryValue;
        if (newCardValue) form.sender_card = newCardValue.cardLastDigits;
    }
);

const receiverAvatar = computed(() => {
    if (typeof selectedReceiver.value === "string")
        return selectedReceiver.value.charAt(0);
    else if (
        selectedReceiver.value &&
        typeof selectedReceiver.value === "object"
    )
        return selectedReceiver.value.fullName.charAt(0);
    return "";
});

const formCurrency = computed(() => {
    const currency = selectedCard.value ? selectedCard.value.currency : "USD";
    form.currency = currency;

    return currency;
});

const submit = async () => {
    await makeTransfer(form)
        .then((res) => {
            router.visit(route("dashboard"), {
                onSuccess: () => {
                    showToast(toast, "success", "Transfer sent", res.data.message);
                },
            });
        })
        .catch((err) => {
            const error = err.response.data.errors;

            if (error) {
                for (const property in error) {
                    if (property in errors) {
                        const key = property as keyof Errors;
                        errors[key] = error[property][0];
                    }
                }
                return;
            }

            showToast(toast, "error", "The transfer has not been sent", err.response.data.message);
        });
};
</script>

<template>
    <AuthenticatedLayout title="Transfer">
        <div class="transfer-page">
            <div class="transfer-page__wrapper">
                <SectionHeader value="Transfer" />
                <div class="w-full flex justify-center mt-5">
                    <Card class="max-w-[65%]">
                        <template #title>
                            <div class="flex justify-evenly">
                                <Avatar
                                    :label="
                                        $page.props.auth.user.name.charAt(0) ??
                                        ''
                                    "
                                    shape="circle"
                                    size="xlarge"
                                    class="transfer-page__avatar"
                                />
                                <Avatar
                                    :label="receiverAvatar"
                                    shape="circle"
                                    size="xlarge"
                                    class="transfer-page__avatar"
                                    icon="pi pi-user"
                                />
                            </div>
                        </template>
                        <template #content>
                            <form
                                @submit.prevent="submit"
                                class="transfer-page__form"
                            >
                                <TransferInput
                                    name="receiver"
                                    :modelError="errors.receiver"
                                >
                                    <Dropdown
                                        v-model="selectedReceiver"
                                        :options="favourites"
                                        optionLabel="fullName"
                                        required
                                        autofocus
                                        filter
                                        editable
                                    >
                                        <template #value="slotProps">
                                            <div
                                                v-if="slotProps.value"
                                                class="flex items-center"
                                            >
                                                <Avatar
                                                    :label="
                                                        slotProps.value.fullName.charAt(
                                                            0
                                                        ) ?? ''
                                                    "
                                                    shape="circle"
                                                    class="mr-3"
                                                />
                                                <div>
                                                    {{
                                                        slotProps.value.fullName
                                                    }}
                                                </div>
                                            </div>
                                            <span v-else>{{
                                                slotProps.placeholder
                                            }}</span>
                                        </template>

                                        <template #option="slotProps">
                                            <div class="flex items-center">
                                                <Avatar
                                                    :label="
                                                        slotProps.option.fullName.charAt(
                                                            0
                                                        ) ?? ''
                                                    "
                                                    shape="circle"
                                                    class="mr-3"
                                                />
                                                <div>
                                                    {{
                                                        slotProps.option
                                                            .fullName
                                                    }}
                                                </div>
                                            </div>
                                        </template>
                                    </Dropdown>
                                </TransferInput>

                                <TextInput
                                    name="message"
                                    v-model="form.message"
                                    :modelError="errors.message"
                                    :required="false"
                                    autocomplete="message"
                                />

                                <TransferInput
                                    name="category"
                                    :modelError="errors.category"
                                >
                                    <CategoriesDropdown
                                        v-model="selectedCategory"
                                    />
                                </TransferInput>

                                <TransferInput
                                    name="sender_card"
                                    label="From card"
                                    :modelError="errors.sender_card"
                                >
                                    <CardListDropdown
                                        v-model="selectedCard"
                                        :cards="cards ?? []"
                                    />
                                </TransferInput>

                                <TransferInput
                                    name="account_number"
                                    label="Account number"
                                    :modelError="errors.account_number"
                                >
                                    <InputMask
                                        id="account_number"
                                        v-model="form.account_number"
                                        mask="99999999999"
                                        placeholder="99999999999"
                                        required
                                    />
                                </TransferInput>

                                <TransferInput
                                    name="amount"
                                    :modelError="errors.amount"
                                >
                                    <InputNumber
                                        v-model="form.amount"
                                        inputId="amount"
                                        mode="currency"
                                        :currency="formCurrency"
                                        locale="en-US"
                                        required
                                    />
                                </TransferInput>

                                <TransferInput
                                    name="date"
                                    :modelError="errors.date"
                                >
                                    <Calendar
                                        v-model="form.date"
                                        showIcon
                                        :minDate="new Date()"
                                    />
                                </TransferInput>

                                <Button type="submit" label="Send" />
                            </form>
                        </template>
                    </Card>
                </div>
            </div>
            <TransferInfo v-if="width >= 768" class="transfer-page__info" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.transfer-page {
    @apply flex flex-row w-full h-full;

    &__wrapper {
        @apply w-full md:w-[70%];
    }

    &__form {
        @apply m-3 mx-8 mt-10 flex flex-col gap-4;
    }

    &__info {
        @apply w-[30%] h-screen;
    }

    &__avatar {
        @apply w-[130px] h-[130px];
    }
}
</style>
