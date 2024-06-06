<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import Link from "@js/Components/atoms/Link.vue";
import Card from "@js/Components/atoms/Card.vue";
import Steps from "primevue/steps";
import Button from "primevue/button";
import { RegistrationForm } from "@js/types/interfaces";
import BasicInfoForm from "@js/Components/organisms/BasicInfoForm.vue";
import PersonalDataForm from "@js/Components/organisms/PersonalDataForm.vue";
import BankingProductSelection from "@js/Components/organisms/BankingProductSelection.vue";
import BankingProduct from "@js/enums/BankingProduct";
import SlideTransition from "@js/Components/atoms/SlideTransition.vue";
import { UserDataErrors } from "@js/types/types";

const loading = ref(false);
const currentStep = ref(0);

const items = ref([
    { label: "Basic informations" },
    { label: "Personal Data" },
    { label: "Selecting a Banking Product" },
]);

const form: RegistrationForm = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    password_confirmation: "",
    ssn_number: "",
    phone_number: "",
    city: "",
    zip_code: "",
    street: "",
    house_number: "",
    banking_product: BankingProduct.Personal,
});

const stepsComponents = [
    BasicInfoForm,
    PersonalDataForm,
    BankingProductSelection,
];

const currentStepComponent = computed(() => stepsComponents[currentStep.value]);

const submit = () => {
    loading.value = true;

    form.post(route("register"), {
        onFinish: () => {
            showError();
            loading.value = false;
        },
    });
};

const showError = () => {
    const errors: UserDataErrors = form.errors;
    const errorGroups = [
        ["name", "surname", "password", "password_confirmation", "email"],
        [
            "ssn_number",
            "phone_number",
            "city",
            "zip_code",
            "street",
            "house_number",
        ],
        ["banking_product"],
    ];

    for (let i = 0; i < errorGroups.length; i++) {
        if (errorGroups[i].some((key) => errors[key as keyof typeof errors])) {
            currentStep.value = i;
            break;
        }
    }
};

const nextStep = () => {
    if (currentStep.value < stepsComponents.length - 1) {
        currentStep.value++;
    } else {
        submit();
    }
};

const prevStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
};
</script>

<template>
    <GuestLayout title="Create an account">
        <Card>
            <template #title>Create an account</template>
            <template #subtitle>
                <Steps
                    v-model:activeStep="currentStep"
                    :model="items"
                    class="steps"
                />
            </template>
            <template #content>
                <form @submit.prevent="nextStep">
                    <SlideTransition name="slide-fade" mode="out-in">
                        <component
                            :is="currentStepComponent"
                            :form="form"
                            :key="currentStep"
                        />
                    </SlideTransition>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :route="route('login')"
                            content="Already registered?"
                            :link="true"
                        />
                        <Button
                            v-if="currentStep != 0"
                            class="ms-4"
                            label="Back"
                            @click="prevStep"
                        />
                        <Button
                            class="ms-4"
                            type="submit"
                            :label="
                                currentStep === items.length - 1
                                    ? 'Submit'
                                    : 'Next'
                            "
                            :loading="loading"
                        />
                    </div>
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>

<style scoped>
.input {
    @apply mt-1 block w-full;
}

.input:hover {
    @apply border-primary;
}
</style>
