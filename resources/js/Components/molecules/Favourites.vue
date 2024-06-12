<script setup lang="ts">
import { FavouriteAccount } from "@js/types/types";
import Avatar from "primevue/avatar";

const props = defineProps<{
    favourites: FavouriteAccount[];
}>();

console.log(props.favourites);
</script>

<template>
    <div class="favourites">
        <Avatar
            v-for="favourite in favourites"
            :label="favourite.fullName.charAt(0)"
            class="favourites__avatar"
            size="xlarge"
            shape="circle"
        />
    </div>
</template>

<style scoped lang="scss">
.favourites {
    @apply mx-6 mb-5 py-4 flex justify-evenly bg-gradient-to-r from-neutral-950 to-primary-500 rounded-full shadow-lg shadow-gray-500;

    &__avatar {
        @apply cursor-pointer hover:bg-gray-400 transition-colors;
    }
}
</style>
