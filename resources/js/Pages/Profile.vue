<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import Avatar from "primevue/avatar";
import Card from "@js/Components/atoms/Card.vue";
import ProfileDataList from "@js/Components/molecules/ProfileDataList.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import UpdateContactDialog from "@js/Components/molecules/UpdateContactDialog.vue";
import { ProfileDataOption } from "@js/types/interfaces";
import { formatDate } from "@js/helpers/helpers";
import Divider from "primevue/divider";
import { ref } from "vue";

const dialogVisible = ref(false);

const personalData = ref<ProfileDataOption[]>([
    {
        key: "Full name",
        value: "John Doe",
        hidden: false,
        isVisible: true,
    },
    {
        key: "SSN number",
        value: "23863-7485",
        hidden: true,
        isVisible: false,
    },
    {
        key: "City",
        value: "Jessiechester, 23863-7485",
        hidden: true,
        isVisible: false,
    },
    {
        key: "Street",
        value: "Schmidt Key 25564",
        hidden: true,
        isVisible: false,
    },
]);

const contactData = ref<ProfileDataOption[]>([
    {
        key: "Email",
        value: "john.doe@example.com",
        hidden: false,
        isVisible: true,
        editable: true,
    },
    {
        key: "Phone number",
        value: "(437) 432-7217",
        hidden: true,
        isVisible: false,
        editable: true,
    },
]);

const statsData = ref<ProfileDataOption[]>([
    {
        key: "Cards owned",
        value: 2,
        hidden: false,
        isVisible: true,
    },
    {
        key: "Joined",
        value: formatDate(new Date("2024-06-14")),
        hidden: false,
        isVisible: true,
    },
]);

const updateVisible = (_value: boolean) => {
    dialogVisible.value = false;
};
</script>

<template>
    <AuthenticatedLayout title="Profile">
        <div class="w-[100%] flex flex-col">
            <SectionHeader value="Profile" />
            <div class="w-[100%] flex items-center justify-center">
                <Card class="profile">
                    <template #title>
                        <div class="profile__header">
                            <div class="relative overflow-hidden">
                                <Avatar
                                    label="J"
                                    size="xlarge"
                                    shape="circle"
                                    class="profile__avatar"
                                />
                                <button
                                    class="profile__edit-button pi pi-pencil"
                                />
                            </div>
                            <p class="profile__name">John <span>Doe</span></p>
                        </div>
                    </template>
                    <template #content>
                        <div class="flex flex-row justify-evenly">
                            <ProfileDataList
                                title="Personal data"
                                :items="personalData"
                            />
                            <Divider layout="vertical" />
                            <ProfileDataList
                                title="Contact"
                                :items="contactData"
                                :dialogVisible="dialogVisible"
                                @openDialog="dialogVisible = true"
                            />
                            <Divider layout="vertical" />
                            <ProfileDataList
                                title="Statistics"
                                :items="statsData"
                            />
                        </div>
                    </template>
                </Card>
            </div>
        </div>
        <UpdateContactDialog
            :visible="dialogVisible"
            @update:visible="updateVisible"
        />
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.profile {
    @apply w-[90%] md:w-[80%] mt-3;

    &__header {
        @apply flex items-center gap-4;
    }

    &__avatar {
        @apply w-[2em] h-[2em] md:w-[6em] md:h-[6em] overflow-hidden relative;
    }

    &__edit-button {
        @apply absolute top-0 bottom-0 left-0 right-0 bg-neutral-950/75 rounded-full text-gray-400 opacity-0 transition-[opacity];

        &:hover {
            @apply opacity-100;
        }
    }

    &__name {
        @apply text-4xl md:text-8xl font-normal;

        span {
            @apply font-bold;
        }
    }
}
</style>
