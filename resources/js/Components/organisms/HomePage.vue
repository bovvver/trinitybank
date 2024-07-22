<script setup lang="ts">
import SectionHeader from "@js/Components/atoms/SectionHeader.vue";
import CreditCard from "@js/Components/molecules/CreditCard.vue";
import Slider, { ChangedEvent } from "@egjs/vue3-flicking";
import "@egjs/vue3-flicking/dist/flicking.css";
import Favourites from "@js/Components/molecules/Favourites.vue";
import LatestTransfers from "@js/Components/organisms/LatestTransfers.vue";
import { useDashboardStore } from "@js/stores/dashboard";
import { storeToRefs } from "pinia";
import { computed, nextTick, onMounted, ref } from "vue";
import Flicking from "@egjs/vue3-flicking";
import { setSelectedAccount } from "@js/api/SessionService";
import { useToast } from "primevue/usetoast";
import { showToast } from "@js/helpers/helpers";
import { router } from "@inertiajs/vue3";

const props = defineProps<{
    selectedCard?: number;
}>();

const toast = useToast();
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

onMounted(async () => {
    await nextTick();
    if (flickingRef.value) {
        try {
            await flickingRef.value.moveTo(findCreditCard());
        } catch (e) {
            showToast(
                toast,
                "info",
                "Card changed",
                "Active card is now disabled. Changing to another card."
            );
        }
        onReady();
    }
});

const shouldRenderCards = computed(() => {
    return creditCards.value && creditCards.value.length > 0;
});

const routeToTransfer = (cardDigits: string) => {
    router.visit(route("transfer", {
        card: cardDigits
    }));
};
</script>

<template>
    <div class="home-wrapper">
        <SectionHeader value="Home" class="mx-6" />
        <Slider v-if="shouldRenderCards" ref="flickingRef" class="py-6">
            <CreditCard
                v-for="card in creditCards"
                :key="card.cardLastDigits"
                :cardNumber="card.cardLastDigits"
                :balance="card.balance"
                :currency="card.currency"
                :grabable="true"
                :cardColor="card.cardColor"
                class="mx-6"
                @primaryClick="routeToTransfer(card.cardLastDigits)"
            />
        </Slider>
        <div v-else class="home-wrapper__no-cards-active">
            <h3>No cards are active</h3>
            <p>Please activate a card or create a new one</p>
        </div>
        <Favourites />
        <LatestTransfers />
    </div>
</template>

<style scoped lang="scss">
.home-wrapper {
    @apply h-full lg:max-w-[40%] xl:max-w-[30%] flex flex-col;

    &__no-cards-active {
        @apply m-6 flex flex-col items-center justify-center bg-gray-100 rounded-md min-h-[250px] min-w-[400px] w-[400px];

        h3 {
            @apply font-bold text-xl;
        }
    }
}
</style>
