<script setup lang="ts">
import TextInput from "@js/Components/molecules/TextInput.vue";
import { RegistrationForm } from "@js/types/interfaces";

defineProps<{
    form: RegistrationForm;
}>();
</script>

<template>
    <div>
        <div class="flex flex-row gap-3">
            <TextInput
                name="name"
                v-model="form.name"
                :modelError="form.errors.name"
                :required="true"
                :autofocus="true"
                autocomplete="name"
                class="w-full"
            />
            <TextInput
                name="surname"
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
            v-model="form.password_confirmation"
            :modelError="form.errors.password_confirmation"
            :required="true"
            autocomplete="new-password"
            class="mt-4"
        />
    </div>
</template>
