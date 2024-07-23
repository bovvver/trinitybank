<script setup lang="ts">
import { useToast } from "primevue/usetoast";
import { showToast } from "@js/helpers/helpers";
import { uploadAvatar } from "@js/api/DataService";
import { router } from "@inertiajs/vue3";

const toast = useToast();

const checkAvatarSize = (size: number) => {
    return size > 5 * 1024 * 1024;
};

const checkAvatarType = (type: string) => {
    return !["image/jpeg", "image/png", "image/jpg"].includes(type);
};

const onAvatarChange = async (e: Event) => {
    const input = e.target as HTMLInputElement;

    if (input.files && input.files.length > 0) {
        const file = input.files[0];

        if (checkAvatarSize(file.size)) {
            showToast(
                toast,
                "warn",
                "Avatar is too large",
                "Maximum size for an avatar is 5MB. Please select smaller image."
            );
            return;
        }
        if (checkAvatarType(file.type)) {
            showToast(
                toast,
                "warn",
                "Wrong file",
                "Please, select PNG or JPG file."
            );
            return;
        }

        const formData = new FormData();
        formData.append("file", file);

        await uploadAvatar(formData)
            .then((res) =>
                router.visit(route("profile"), {
                    onSuccess: () => {
                        showToast(toast, "success", "Success", res.data.message);
                    },
                })
            )
            .catch((_err) => {
                showToast(toast, "error", "Upload failed", "There was an error uploading your avatar. Try again later.");
            });
    }
};
</script>

<template>
    <form class="avatar-upload">
        <input
            id="avatar-upload"
            class="avatar-upload__input"
            name="file"
            type="file"
            accept="image/*"
            @change="onAvatarChange"
        />
        <label class="avatar-upload__button-label" for="avatar-upload">
            <button class="avatar-upload__edit-button pi pi-pencil" />
        </label>
    </form>
</template>

<style lang="scss">
.avatar-upload {
    @apply absolute top-0 left-0 w-[100%] h-[100%];

    &__input {
        @apply hidden;
    }

    &__button-label {
        @apply absolute top-0 bottom-0 left-0 right-0 opacity-0 transition-opacity cursor-pointer flex items-center justify-center;

        &:hover {
            @apply opacity-100;
        }
    }

    &__edit-button {
        @apply w-[6em] md:w-[9em] aspect-square bg-neutral-950/75 rounded-full text-gray-400 translate-y-[-3px] pointer-events-none;
    }
}
</style>
