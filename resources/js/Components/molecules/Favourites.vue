<script setup lang="ts">
import Avatar from "primevue/avatar";
</script>

<template>
    <div class="avatar-wrapper">
        <Avatar label="A" class="avatar" size="xlarge" shape="circle" />
        <Avatar label="G" class="avatar" size="xlarge" shape="circle" />
        <Avatar label="F" class="avatar" size="xlarge" shape="circle" />
        <Avatar label="P" class="avatar" size="xlarge" shape="circle" />
    </div>
</template>

<style scoped>
.avatar-wrapper {
    @apply mx-6 mb-5 py-4 flex justify-evenly bg-gradient-to-r from-neutral-950 to-primary-500 rounded-full shadow-lg shadow-gray-500;
}

.avatar {
    @apply cursor-pointer hover:bg-gray-400 transition-colors;
}
</style>
