<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Link from "@js/Components/atoms/Link.vue";
import Card from "@js/Components/atoms/Card.vue";
import Steps from "primevue/steps";
import Button from "primevue/button";
import { ref } from "vue";
import TextInput from "@js/Components/molecules/TextInput.vue";

const items = ref([
    {
        label: "Basic informations",
    },
    {
        label: "Personal Data",
    },
    {
        label: "Selecting a Banking Product",
    },
    {
        label: "Completion",
    },
]);

const form = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    confirm_password: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "confirm_password");
        },
    });
};
</script>

<template>
    <GuestLayout title="Create an account">
        <Card>
            <template #title>Create an account</template>
            <template #subtitle
                ><Steps :model="items" class="steps"
            /></template>
            <template #content>
                <form @submit.prevent="submit">
                    <div class="flex flex-row gap-3">
                        <TextInput
                            name="name"
                            type="input"
                            v-model="form.name"
                            :modelError="form.errors.name"
                            :required="true"
                            :autofocus="true"
                            autocomplete="name"
                            class="w-full"
                        />
                        <TextInput
                            name="surname"
                            type="input"
                            v-model="form.surname"
                            :modelError="form.errors.surname"
                            :required="true"
                            autocomplete="surname"
                            class="w-full"
                        />
                    </div>

                    <TextInput
                        name="email"
                        type="email"
                        v-model="form.email"
                        :modelError="form.errors.email"
                        :required="true"
                        autocomplete="username"
                        class="mt-4"
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
                        <Link
                            :route="route('login')"
                            content="Already registered?"
                            :link="true"
                        />

                        <Button
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Next
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
