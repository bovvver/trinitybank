<script setup lang="ts">
import { computed } from "vue";
import GuestLayout from "@js/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Card from "@js/Components/atoms/Card.vue";
import Button from "primevue/button";
import Link from "@js/Components/atoms/Link.vue";
import { ref } from "vue";

const loading = ref(false);

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    loading.value = true;
    form.post(route("verification.send"), {
        onFinish: () => {
            loading.value = false;
        },
    });
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <GuestLayout title="Email Verification">
        <Card>
            <template #title>Verify Email</template>
            <template #subtitle
                >Before you begin, verify your email address by clicking the
                link sent to your email address.</template
            >
            <template #content>
                <div
                    class="mb-4 font-medium text-sm text-green-600"
                    v-if="verificationLinkSent"
                >
                    Email sent.
                </div>

                <form @submit.prevent="submit">
                    <div class="mt-4 flex items-center justify-between">
                        <Button
                            type="submit"
                            label="Resend Verification Email"
                            :loading="loading"
                        />

                        <Link
                            method="post"
                            content="Log out"
                            :route="route('logout')"
                            :class="{ 'opacity-25': form.processing }"
                        />
                    </div>
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>
