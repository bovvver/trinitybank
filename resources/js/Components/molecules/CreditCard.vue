<script setup lang="ts">
import { CardColors } from "@js/types/types";
import { reactive, ref } from "vue";

const props = defineProps<{
    cardNumber: string;
    balance: string;
    currency: string;
    grabable?: boolean;
    large?: boolean;
    button?: string;
    secondButton?: string;
    cardColor?: CardColors;
}>();

const handleMouseDown = () => {
    if (props.grabable) isGrabbing.value = true;
};

const handleMouseUp = () => {
    if (props.grabable) isGrabbing.value = false;
};

const setCardColor = (color: CardColors | undefined) => {
    switch (color) {
        case "Purple":
            return {cardColor: "purple-card", buttonColor: "purple-button"};
        case "Yellow":
            return {cardColor: "yellow-card", buttonColor: "yellow-button"};;
        case "Green":
            return {cardColor: "green-card", buttonColor: "green-button"};;
        default:
            return {cardColor: "blue-card", buttonColor: "blue-button"};;
    }
};

const isGrabbing = ref(false);
const cardColors = reactive(setCardColor(props.cardColor));
</script>

<template>
    <div
        class="credit-card"
        :class="[
            cardColors.cardColor,
            { grabbing: isGrabbing, grabable: grabable, large: large },
        ]"
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
        <p class="credit-card__number">**** {{ cardNumber }}</p>
        <p class="credit-card__header">Balance</p>
        <p class="credit-card__balance">
            <span class="credit-card__balance-currency">{{ currency }}</span>
            {{ balance }}
        </p>
        <div class="credit-card__buttons">
            <button :class="cardColors.buttonColor">{{ button ?? "Transfer" }}</button>
            <button :class="cardColors.buttonColor" v-if="secondButton">{{ secondButton }}</button>
        </div>
    </div>
</template>

<style scoped lang="scss">
.credit-card {
    @apply relative rounded-lg p-6 text-white min-w-[400px] w-[400px] min-h-[250px] bg-cover shadow-lg shadow-gray-600;

    &.grabbing {
        @apply cursor-grabbing;
    }

    &.grabable {
        @apply cursor-grab;
    }

    &.large {
        @apply min-h-[400px] w-[700px];
    }

    &__number {
        @apply absolute left-0 pl-6;
    }

    &__header {
        @apply absolute font-bold text-lg top-[30%] left-0 pl-6;
    }

    &__balance {
        @apply absolute font-bold text-3xl top-[39%] left-0 pl-6;

        &-currency {
            @apply text-sm;
        }
    }

    &__buttons {
        @apply absolute bottom-0 right-0 mr-6 mb-6 flex flex-row-reverse gap-2;

        button {
            @apply  px-4 py-1 rounded font-bold shadow-sm shadow-gray-500 hover:text-white transition-colors;
        }
    }
}
</style>
