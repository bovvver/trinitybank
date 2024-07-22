<script setup lang="ts">
import AuthenticatedLayout from "@js/Layouts/AuthenticatedLayout.vue";
import Avatar from "primevue/avatar";
import ProfileDataList from "@js/Components/molecules/ProfileDataList.vue";
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import UpdateContactDialog from "@js/Components/molecules/UpdateContactDialog.vue";
import { ProfileDataOption, ProfileProps } from "@js/types/interfaces";
import { formatDate } from "@js/helpers/helpers";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const { cardsCount, personalData } = usePage().props as Partial<ProfileProps>;

const dialogVisible = ref(false);

const personalDataList = ref<ProfileDataOption[]>([
    {
        key: "Full name",
        value: personalData!.fullName,
        hidden: false,
        isVisible: true,
    },
    {
        key: "SSN number",
        value: personalData!.ssnNumber,
        hidden: true,
        isVisible: false,
    },
    {
        key: "City",
        value: personalData!.city,
        hidden: true,
        isVisible: false,
    },
    {
        key: "Street",
        value: personalData!.street,
        hidden: true,
        isVisible: false,
    },
]);

const contactDataList = ref<ProfileDataOption[]>([
    {
        key: "Email",
        value: personalData!.email,
        hidden: false,
        isVisible: true,
        editable: true,
    },
    {
        key: "Phone number",
        value: personalData!.phoneNumber,
        hidden: true,
        isVisible: false,
        editable: true,
    },
]);

const statsDataList = ref<ProfileDataOption[]>([
    {
        key: "Cards owned",
        value: cardsCount!,
        hidden: false,
        isVisible: true,
    },
    {
        key: "Joined",
        value: formatDate(new Date(personalData!.joined)),
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
            <div class="profile">
                <div class="profile__header">
                    <div class="relative overflow-hidden">
                        <Avatar
                            label="J"
                            size="xlarge"
                            shape="circle"
                            class="profile__avatar"
                        />
                        <button class="profile__edit-button pi pi-pencil" />
                    </div>
                    <p class="profile__name">{{ personalData?.fullName }}</p>
                </div>
                <div class="flex flex-row gap-10 my-2 md:ml-[10em]">
                    <ProfileDataList
                        title="Personal data"
                        :items="personalDataList"
                    />
                    <ProfileDataList
                        title="Contact"
                        :items="contactDataList"
                        :dialogVisible="dialogVisible"
                        @openDialog="dialogVisible = true"
                    />
                    <ProfileDataList
                        title="Statistics"
                        :items="statsDataList"
                    />
                </div>
            </div>
        </div>
        <UpdateContactDialog
            :visible="dialogVisible"
            :fullName="personalData?.fullName ?? ''"
            :email="personalData?.email ?? ''"
            :phoneNumber="personalData?.phoneNumber ?? ''"
            @update:visible="updateVisible"
        />
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.profile {
    @apply w-[100%] flex flex-col p-10 text-neutral-800;

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
