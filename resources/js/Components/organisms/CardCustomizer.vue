<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { setSelectedAccount } from "@js/api/DataService";
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import { showToast } from "@js/helpers/helpers";
import useWindowWidth from "@js/hooks/useScreenWidth";
import { DashboardCards } from "@js/types/interfaces";
import { useToast } from "primevue/usetoast";
import { computed, ref, watch } from "vue";

const props = defineProps<{
    cards: DashboardCards[];
    modelValue: DashboardCards | null;
}>();

const width = useWindowWidth();
const toast = useToast();
const customizerColor = ref(props.modelValue?.cardColor);
const cardStatus = ref<boolean>(!!props.modelValue?.active);

const isCardActive = computed(() => {
    return cardStatus.value ? "Disable" : "Enable";
});

const reverseCardStatus = () => {
    cardStatus.value = !cardStatus.value;
};

const submitChanges = async () => {
    if (customizerColor.value && props.modelValue?.cardLastDigits) {
        await setSelectedAccount(
            customizerColor.value,
            cardStatus.value,
            props.modelValue.cardLastDigits
        ).then((res) =>
            router.visit(route("dashboard"), {
                onSuccess: () => {
                    showToast(toast, "success", "Success", res.data.message);
                },
            })
        );
    }
};

watch(
    () => props.modelValue?.cardColor,
    () => {
        customizerColor.value = props.modelValue?.cardColor;
    }
);

watch(
    () => props.modelValue?.active,
    () => {
        cardStatus.value = !!props.modelValue?.active;
    }
);
</script>

<template>
    <div v-if="modelValue" class="card-customizer">
        <CreditCard
            :cardNumber="modelValue.cardLastDigits"
            :balance="modelValue.balance"
            :currency="modelValue.currency"
            :large="width >= 1024"
            :button="isCardActive"
            secondButton="Save"
            :cardColor="customizerColor"
            @primaryClick="reverseCardStatus"
            @secondaryClick="submitChanges"
        />
        <div class="flex gap-2">
            <button
                @click="customizerColor = 'Blue'"
                class="card-customizer__button blue-card"
            />
            <button
                @click="customizerColor = 'Yellow'"
                class="card-customizer__button yellow-card"
            />
            <button
                @click="customizerColor = 'Green'"
                class="card-customizer__button green-card"
            />
            <button
                @click="customizerColor = 'Purple'"
                class="card-customizer__button black-card"
            />
        </div>
    </div>
</template>

<style scoped lang="scss">
.card-customizer {
    @apply w-full flex flex-col gap-5 items-center;

    &__button {
        @apply w-[70px] h-[50px] bg-cover rounded-lg border-2 border-neutral-800 hover:scale-110 hover:shadow-lg shadow-gray-600 transition-transform;
    }
}

.blue-card {
    @apply bg-card-blue bg-[#3d87ff];
}
.yellow-card {
    @apply bg-card-yellow bg-[#ffff99];
}
.green-card {
    @apply bg-card-green bg-[#00bb77];
}
.black-card {
    @apply bg-card-black bg-[#000000];
}
</style>
