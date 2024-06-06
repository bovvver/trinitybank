<script setup lang="ts">
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import Card from "@js/Components/atoms/Card.vue";
import Link from "@js/Components/atoms/Link.vue";
</script>

<template>
    <GuestLayout title="Welcome">
        <Card>
            <template #title class="title">Welcome!</template>
            <template #subtitle>Please select a login method.</template>
            <template #content>
                <div class="flex flex-col gap-y-3">
                    <Link
                        content="Login with email / SSN number"
                        :route="route('login')"
                    />
                    <Link
                        content="Create an account"
                        :route="route('register')"
                        severity="secondary"
                    />
                </div>
            </template>
        </Card>
    </GuestLayout>
</template>
