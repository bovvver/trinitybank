<script setup lang="ts">
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import InputMask from "primevue/inputmask";
import InputNumber from "primevue/inputnumber";
import Button from "primevue/button";
import Calendar from "primevue/calendar";
import Dropdown from "primevue/dropdown";
import TransferInput from "@js/Components/molecules/TransferInput.vue";
import TransferInfo from "@js/Components/atoms/TransferInfo.vue";
import { ref } from "vue";
import Avatar from "primevue/avatar";
import useWindowWidth from "@js/hooks/useScreenWidth";

const options = ref([
    { name: "John Doe" },
    { name: "Emily Smith" },
    { name: "Jacob Muller" },
    { name: "Walt Disney" },
]);

const width = useWindowWidth();

const form = useForm({
    receiver: "",
    account_number: "",
    amount: 0,
    currency: "",
    date: "",
});

const submit = () => {
    form.post(route(""), {
        onFinish: () => {},
    });
};
</script>

<template>
    <AuthenticatedLayout title="Transfer">
        <div class="transfer-page">
            <div class="transfer-page__wrapper">
                <SectionHeader value="Transfer" />
                <form @submit.prevent="submit" class="transfer-page__form">
                    <TransferInput
                        name="receiver"
                        :modelError="form.errors.receiver"
                    >
                        <Dropdown
                            v-model="form.receiver"
                            :options="options"
                            optionLabel="receiver"
                            required
                            autofocus
                            editable
                        >
                            <template #value="slotProps">
                                <div
                                    v-if="slotProps.value"
                                    class="flex items-center"
                                >
                                    <Avatar
                                        :label="slotProps.value.name.charAt(0)"
                                        shape="circle"
                                        class="mr-3"
                                    />
                                    <div>{{ slotProps.value.name }}</div>
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>

                            <template #option="slotProps">
                                <div class="flex items-center">
                                    <Avatar
                                        :label="slotProps.option.name.charAt(0)"
                                        shape="circle"
                                        class="mr-3"
                                    />
                                    <div>{{ slotProps.option.name }}</div>
                                </div>
                            </template>
                        </Dropdown>
                    </TransferInput>

                    <TransferInput
                        name="account_number"
                        label="Account number"
                        :modelError="form.errors.account_number"
                    >
                        <InputMask
                            id="account_number"
                            v-model="form.account_number"
                            mask="9999-9999-9999-9999"
                            placeholder="9999-9999-9999-9999"
                            required
                            :invalid="!!form.errors.account_number"
                        />
                    </TransferInput>

                    <TransferInput
                        name="amount"
                        :modelError="form.errors.amount"
                    >
                        <InputNumber
                            v-model="form.amount"
                            inputId="amount"
                            mode="currency"
                            currency="USD"
                            locale="en-US"
                            required
                        />
                    </TransferInput>

                    <TransferInput name="date" :modelError="form.errors.date">
                        <Calendar
                            v-model="form.date"
                            showIcon
                            :minDate="new Date()"
                        />
                    </TransferInput>

                    <Button type="submit" label="Send" />
                </form>
            </div>
            <TransferInfo v-if="width >= 768" class="transfer-page__info" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.transfer-page {
    @apply flex flex-row w-full h-full;

    &__wrapper {
        @apply w-full md:w-[40%] h-full;
    }

    &__form {
        @apply m-3 mx-8 mt-10 flex flex-col gap-4;
    }

    &__info {
        @apply w-[60%] h-screen;
    }
}
</style>
