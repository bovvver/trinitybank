<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Link from "@js/Components/atoms/Link.vue";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import TextInput from "@js/Components/molecules/TextInput.vue";
import { ref } from "vue";

const loading = ref(false);

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const submit = () => {
    loading.value = true;

    form.post(route("login"), {
        onFinish: () => {
            loading.value = false;
            form.reset("password");
        },
    });
};
</script>

<template>
    <GuestLayout title="Log in">
        <Card>
            <template #title>Log In</template>
            <template #subtitle>
                <div v-if="status" class="font-medium text-green-600">
                    {{ status }}
                </div>
            </template>
            <template #content>
                <form @submit.prevent="submit">
                    <TextInput
                        name="username"
                        type="input"
                        v-model="form.username"
                        :modelError="form.errors.username"
                        :required="true"
                        :autofocus="true"
                        autocomplete="username"
                        label="Email / SSN Number"
                    />

                    <TextInput
                        name="password"
                        type="password"
                        v-model="form.password"
                        :modelError="form.errors.password"
                        :required="true"
                        autocomplete="current-password"
                        class="mt-4"
                    />

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model="form.remember"
                                :binary="true"
                            />
                            <span class="ms-2 text-sm text-gray-600"
                                >Remember me</span
                            >
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :route="route('password.request')"
                            content="Forgot your password?"
                            :link="true"
                        />
                        <Button
                            class="ms-4"
                            type="submit"
                            label="Log in"
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
