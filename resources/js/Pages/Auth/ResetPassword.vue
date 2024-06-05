<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";
import TextInput from "@js/Components/molecules/TextInput.vue";
import { ref } from "vue";

const loading = ref(false);

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    loading.value = true;

    form.post(route("password.store"), {
        onFinish: () => {
            loading.value = false;
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout title="Reset Password">
        <Card>
            <template #title>Reset Your Password</template>
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
                        v-model="form.password_confirmation"
                        :modelError="form.errors.password_confirmation"
                        :required="true"
                        autocomplete="new-password"
                        class="mt-4"
                    />

                    <div class="flex items-center justify-end mt-4">
                        <Button
                            type="submit"
                            label="Reset Password"
                            :loading="loading"
                        />
                    </div>
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>
