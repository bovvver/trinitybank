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
                        content="Login with username"
                        :route="route('login')"
                    />
                    <Link
                        content="Login with card details"
                        route="/"
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

<style scoped>
.card {
    @apply w-4/5 bg-white bg-opacity-70 md:w-1/2 lg:w-1/3;
}
</style>
