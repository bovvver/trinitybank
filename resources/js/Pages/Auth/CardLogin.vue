<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";
import { computed, ref } from "vue";
import CardLoginNumbers from "@js/Components/molecules/CardLoginNumbers.vue";
import CardLoginForm from "@js/Components/molecules/CardLoginForm.vue";
import SlideTransition from "@js/Components/atoms/SlideTransition.vue";

const loading = ref(false);
const currentStep = ref(0);

defineProps<{
    status?: string;
}>();

const form = useForm({
    card_number: "",
    cvv_number: 0,
    expiry_date: "",
});

const stepsComponents = [CardLoginNumbers, CardLoginForm];
const currentStepComponent = computed(() => stepsComponents[currentStep.value]);

const submit = () => {
    loading.value = true;

    console.log(form.expiry_date);

    if (form.cvv_number < 1000 || form.cvv_number > 9999) {
        loading.value = false;
        form.errors.cvv_number =
            "Wrong value. Please provide four digits number.";
    } else if (form.expiry_date == "") {
        loading.value = false;
        form.errors.cvv_number = "";
        form.errors.expiry_date = "Field cannot be empty.";
    } else {
        form.post(route("login"), {
            onFinish: () => {
                loading.value = false;
                form.errors.cvv_number = "";
                form.errors.expiry_date = "";
                // form.reset("password");
            },
        });
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
    <GuestLayout title="Log in">
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <Card>
            <template #title>Log In</template>
            <template #content>
                <form @submit.prevent="nextStep">
                    <SlideTransition>
                        <component
                            :is="currentStepComponent"
                            :key="currentStep"
                            :form="form"
                        />
                    </SlideTransition>

                    <div class="flex items-center justify-end mt-4">
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
                                currentStep === stepsComponents.length - 1
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
