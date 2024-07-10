<script setup lang="ts">
import Dialog from "primevue/dialog";
import Avatar from "primevue/avatar";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { useForm } from "@inertiajs/vue3";

defineProps<{
    visible: boolean;
}>();

const form = useForm({
    phone_number: "",
    email: "",
});

const emit = defineEmits(["update:visible"]);

const closeDialog = (isSubmitted: boolean) => {
    emit("update:visible", isSubmitted);
};

const submit = () => {
    console.log(form);

    // form.post(route(""), {
    //     onFinish: () => {},
    // });
    closeDialog(true);
};
</script>

<template>
    <form @submit.prevent="submit">
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
                    <span class="update-dialog__name white-space-nowrap"
                        >John Doe</span
                    >
                </div>
            </template>
            <span class="update-dialog__title">Update your contact data.</span>
            <div class="flex items-center gap-3 mb-3">
                <label for="phoneNumber" class="font-semibold w-[6rem]"
                    >Phone number</label
                >
                <InputText
                    v-model="form.phone_number"
                    id="phoneNumber"
                    class="flex-auto"
                    autocomplete="off"
                />
            </div>
            <div class="flex items-center gap-3 mb-2">
                <label for="email" class="font-semibold w-[6rem]">Email</label>
                <InputText
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="flex-auto"
                    autocomplete="off"
                />
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    severity="secondary"
                    @click="closeDialog(false)"
                    autofocus
                />
                <Button label="Save" type="submit" autofocus />
            </template>
        </Dialog>
    </form>
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
