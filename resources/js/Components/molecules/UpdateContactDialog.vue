<script setup lang="ts">
import Dialog from "primevue/dialog";
import Avatar from "primevue/avatar";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { reactive } from "vue";
import { updateContact } from "@js/api/DataService";
import { useToast } from "primevue/usetoast";
import { showToast } from "@js/helpers/helpers";
import { router } from "@inertiajs/vue3";

const props = defineProps<{
    visible: boolean;
    fullName: string;
    email: string;
    phoneNumber: string;
}>();

const toast = useToast();
const form = reactive({
    phoneNumber: props.phoneNumber,
    email: props.email,
});
const errors = reactive({
    phoneNumber: "",
    email: "",
});

const emit = defineEmits(["update:visible"]);

const resetErrors = () => {
    errors.email = "";
    errors.phoneNumber = "";
};

const closeDialog = (isSubmitted: boolean) => {
    emit("update:visible", isSubmitted);
    resetErrors();
};

const submitContact = async () => {
    await updateContact(form.phoneNumber, form.email)
        .then((res) => {
            resetErrors();

            router.visit(route("profile"), {
                onSuccess: () => {
                    showToast(toast, "success", "Success", res.data.message);
                },
            });
            closeDialog(true);
        })
        .catch((err) => {
            const responseErrors = err.response.data.errors;

            errors.phoneNumber = responseErrors.phoneNumber ? responseErrors.phoneNumber[0] : "";
            errors.email = responseErrors.email ? responseErrors.email[0] : "";
        });
};
</script>

<template>
    <Dialog
        :visible="visible"
        @update:visible="closeDialog"
        modal
        header="Edit Profile"
        class="update-dialog"
    >
        <template #header>
            <div class="update-dialog__header">
                <Avatar label="J" shape="circle" />
                <span class="update-dialog__name white-space-nowrap">{{
                    fullName
                }}</span>
            </div>
        </template>
        <span class="update-dialog__title">Update your contact data.</span>
        <div class="flex items-center gap-3 mb-3">
            <label for="phoneNumber" class="font-semibold w-[6rem]"
                >Phone number</label
            >
            <div class="flex flex-col">
                <InputText
                    v-model="form.phoneNumber"
                    id="phoneNumber"
                    class="flex-auto"
                    autocomplete="off"
                />
                <small v-if="errors.phoneNumber" class="text-red-600">{{
                    errors.phoneNumber
                }}</small>
            </div>
        </div>
        <div class="flex items-center gap-3 mb-2">
            <label for="email" class="font-semibold w-[6rem]">Email</label>
            <div class="flex flex-col">
                <InputText
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="flex-auto"
                    autocomplete="off"
                />
                <small v-if="errors.email" class="text-red-600">{{
                    errors.email
                }}</small>
            </div>
        </div>
        <template #footer>
            <Button
                label="Cancel"
                severity="secondary"
                @click="closeDialog(false)"
                autofocus
            />
            <Button label="Save" @click="submitContact" autofocus />
        </template>
    </Dialog>
</template>

<style setup lang="scss">
.update-dialog {
    @apply w-[25rem];

    &__header {
        @apply inline-flex items-center justify-center gap-2;
    }

    &__name {
        @apply font-bold;
    }

    &__title {
        @apply text-surface-600 dark:text-surface-0/70 block mb-5;
    }
}
</style>
