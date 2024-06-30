<script setup lang="ts">
import { ProfileDataOption } from "@js/types/interfaces";

defineProps<{
    title: string;
    items: ProfileDataOption[];
    dialogVisible?: boolean;
}>();

const emit = defineEmits(["openDialog"]);

const displayItem = (item: ProfileDataOption) => {
    return item.hidden && !item.isVisible ? "*****" : item.value;
};

const toggleVisibility = (item: ProfileDataOption) => {
    item.isVisible = !item.isVisible;
};
</script>

<template>
    <div>
        <h2 class="data-list__title">{{ title }}</h2>
        <template v-for="item in items">
            <p class="data-list__header">{{ item.key }}</p>
            <p class="data-list__item">
                {{ displayItem(item) }}
                <button
                    v-ripple
                    class="data-list__icon pi"
                    :class="{
                        'pi-eye-slash': !item.isVisible,
                        'pi-eye': item.isVisible,
                    }"
                    @click="toggleVisibility(item)"
                    v-if="item.hidden"
                />
                <button
                    v-ripple
                    class="data-list__icon pi pi-pencil"
                    @click="emit('openDialog')"
                    v-if="item.editable"
                />
            </p>
        </template>
    </div>
</template>

<style scoped lang="scss">
.data-list {
    &__title {
        @apply text-xl font-bold mb-3;
    }

    &__header {
        @apply font-bold;
    }

    &__item {
        @apply cursor-default;

        &:hover button {
            @apply opacity-100;
        }
    }

    &__icon {
        @apply ml-2 text-gray-500 opacity-0 transition-[opacity] translate-y-[10%];
    }
}
</style>
