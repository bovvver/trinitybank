<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";
import TextInput from "@js/Components/molecules/TextInput.vue";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout title="Forgot Password">
        <Card>
            <template #title>Reset your password</template>
            <template #subtitle
                >Please enter your email address so we can help you get your
                account back.</template
            >
            <template #content>
                <div
                    v-if="status"
                    class="mb-4 font-medium text-sm text-green-600"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <TextInput
                        name="email"
                        type="email"
                        v-model="form.email"
                        :modelError="form.errors.email"
                        :required="true"
                        :autofocus="true"
                        autocomplete="username"
                    />

                    <div class="flex items-center justify-end mt-4">
                        <Button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Email Password Reset Link
                        </Button>
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
