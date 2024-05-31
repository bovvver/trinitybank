<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import TextInput from "@js/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout title="Confirm Password">
        <Card>
            <template #title>Confirm password</template>
            <template #subtitle>
                Please confirm your password before continuing.
            </template>
            <template #content>
                <form @submit.prevent="submit">
                    <TextInput
                        name="password"
                        type="password"
                        v-model="form.password"
                        :modelError="form.errors.password"
                        :required="true"
                        :autofocus="true"
                        autocomplete="current-password"
                    />
                    <div class="flex justify-end mt-4">
                        <Button
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Confirm
                        </Button>
                    </div>
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>
