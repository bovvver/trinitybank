<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";
import TextInput from "@js/Components/molecules/TextInput.vue";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    confirm_password: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => {
            form.reset("password", "confirm_password");
        },
    });
};
</script>

<template>
    <GuestLayout title="Reset Password">
        <Card>
            <template #content>
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

                    <TextInput
                        name="password"
                        type="password"
                        v-model="form.password"
                        :modelError="form.errors.password"
                        :required="true"
                        autocomplete="new-password"
                        class="mt-4"
                    />

                    <TextInput
                        name="confirm_password"
                        type="password"
                        v-model="form.confirm_password"
                        :modelError="form.errors.confirm_password"
                        :required="true"
                        autocomplete="new-password"
                        class="mt-4"
                    />

                    <div class="flex items-center justify-end mt-4">
                        <Button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Reset Password
                        </Button>
                    </div>
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>
