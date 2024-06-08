<script setup lang="ts">
import { ref } from "vue";

defineProps<{
    cardNumber: string;
    balance: number;
}>();

const isGrabbing = ref(false);

const handleMouseDown = () => {
    isGrabbing.value = true;
};

const handleMouseUp = () => {
    isGrabbing.value = false;
};
</script>

<template>
    <div
        class="wrapper"
        :class="{ grabbing: isGrabbing }"
        @mousedown="handleMouseDown"
        @mouseup="handleMouseUp"
        @mouseleave="handleMouseUp"
        @touchstart="handleMouseDown"
        @touchend="handleMouseUp"
    >
        <font-awesome-icon
            :icon="['fas', 'piggy-bank']"
            class="absolute text-black right-0 pr-6 text-2xl"
        />
        <p class="cardNumber">{{ cardNumber }}</p>
        <p class="balanceHeader">Balance</p>
        <p class="balance">$ {{ balance }}</p>
        <button class="button">Transfer</button>
    </div>
</template>

<style scoped>
.wrapper {
    @apply relative bg-primary rounded-lg p-6 text-white min-w-[400px] min-h-[250px] bg-[#3d87ff] bg-cover bg-card-wave-background 
    shadow-lg shadow-gray-600 cursor-grab;
}

.wrapper.grabbing {
    cursor: grabbing;
}

.cardNumber {
    @apply absolute left-0 pl-6;
}

.balanceHeader {
    @apply absolute font-bold text-lg top-[30%] left-0 pl-6;
}

.balance {
    @apply absolute font-bold text-3xl top-[39%] left-0 pl-6;
}

.button {
    @apply absolute bottom-0 right-0 bg-white text-primary px-4 py-1 rounded font-bold mr-6 mb-6 shadow-sm shadow-gray-500 hover:bg-primary hover:text-white transition-colors;
}
</style>
