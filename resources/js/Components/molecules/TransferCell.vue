<script setup lang="ts">
import Avatar from "primevue/avatar";

defineProps<{
    name: string;
    description: string;
    amount: number;
    date: Date;
}>();

const formatDate = (date: Date) => {
    const msDiff = new Date().getTime() - date.getTime();

    const minutesDiff = Math.floor(msDiff / (1000 * 60));
    const hoursDiff = Math.floor(msDiff / (1000 * 60 * 60));
    const daysDiff = Math.floor(msDiff / (1000 * 60 * 60 * 24));

    if (minutesDiff <= 1) return "A moment ago";
    else if (minutesDiff < 60) return `${minutesDiff} minutes ago`;
    else if (hoursDiff < 24) return `${hoursDiff} hours ago`;
    else if (daysDiff == 1) return "Yesterday";
    else if (daysDiff < 7) return `${daysDiff} days ago`;
    else return date.toDateString().split(" ").slice(1).join(" ");
};

const displayCorrectAmount = (amount: number) => {
    if (amount >= 0) return `$${amount}`;
    return `-$${amount.toString().substring(1)}`;
};
</script>

<template>
    <div class="cell-wrapper">
        <Avatar size="large" :label="name.charAt(0)" shape="circle" />
        <div>
            <p class="name">{{ name }}</p>
            <p class="description">{{ description }}</p>
            <p
                class="amount"
                :class="{ positive: amount >= 0, negative: amount < 0 }"
            >
                {{ displayCorrectAmount(amount) }}
            </p>
            <p class="date">{{ formatDate(date) }}</p>
        </div>

        <div class="separator" />
    </div>
</template>

<style scoped>
.cell-wrapper {
    @apply relative flex items-center gap-3 px-2 py-2;
}

.name {
    @apply text-xl font-bold text-gray-800;
}

.description {
    @apply text-gray-700;
}

.amount {
    @apply pr-6 absolute right-0 top-[32%] -translate-y-[50%] text-xl font-bold;
}

.date {
    @apply pr-6 absolute right-0 top-[70%] -translate-y-[50%] text-base;
}

.separator {
    @apply absolute bottom-0 left-[50%] w-4/5 bg-gray-300 h-[1px] -translate-x-[50%];
}

.positive {
    @apply text-green-500;
}

.negative {
    @apply text-red-500;
}
</style>
