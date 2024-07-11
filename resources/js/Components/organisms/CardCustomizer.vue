<script setup lang="ts">
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import useWindowWidth from "@js/hooks/useScreenWidth";

const width = useWindowWidth();
</script>

<template>
    <div class="card-customizer">
        <CreditCard
            cardNumber="9999"
            balance="9999.99"
            currency="XXX"
            :large="width >= 1024"
            button="Disable"
            secondButton="Change currency"
        />
        <div class="flex gap-2">
            <button class="card-customizer__button blue-card" />
            <button class="card-customizer__button yellow-card" />
            <button class="card-customizer__button green-card" />
            <button class="card-customizer__button black-card" />
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
