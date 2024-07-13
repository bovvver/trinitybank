<script setup lang="ts">
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import Slider, { ChangedEvent } from "@egjs/vue3-flicking";
import "@egjs/vue3-flicking/dist/flicking.css";
import Favourites from "@js/Components/molecules/Favourites.vue";
import LatestTransfers from "@js/Components/organisms/LatestTransfers.vue";
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";
import { nextTick, onMounted, ref } from "vue";
import Flicking from "@egjs/vue3-flicking";
import { setSelectedAccount } from "@js/api/SessionService";

const props = defineProps<{
    selectedCard?: number;
}>();

const dashboardStore = useDashboardStore();
const { creditCards, accountsData } = storeToRefs(dashboardStore);

const flickingRef = ref<Flicking | null>(null);

const onReady = () => {
    if (flickingRef.value) {
        flickingRef.value.align = "center";
        flickingRef.value.on("changed", onSlideChanged);
    }
};

const onSlideChanged = (e: ChangedEvent) => {
    const id = e.index;
    dashboardStore.changeStore(id);
    if (accountsData.value) setSelectedAccount(accountsData.value[id].id);
};

const findCreditCard = () => {
    const cardId = accountsData.value?.findIndex(
        (account) => account.id === props.selectedCard
    );
    return cardId ?? -1;
};

onMounted(() => {
    nextTick(() => {
        if (flickingRef.value) {
            flickingRef.value.moveTo(findCreditCard());
            onReady();
        }
    });
});
</script>

<template>
    <div class="home-wrapper">
        <SectionHeader value="Home" class="mx-6" />
        <Slider ref="flickingRef" class="py-6">
            <CreditCard
                v-for="card in creditCards"
                :key="card.cardLastDigits"
                :cardNumber="card.cardLastDigits"
                :balance="card.balance"
                :currency="card.currency"
                :grabable="true"
                class="mx-6"
            />
        </Slider>
        <Favourites />
        <LatestTransfers />
    </div>
</template>

<style scoped>
.home-wrapper {
    @apply h-full lg:max-w-[40%] xl:max-w-[30%] flex flex-col;
}
</style>
