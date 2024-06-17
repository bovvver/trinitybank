import {
    DashboardTransfers,
    DashboardFavourites,
    DashboardIncome,
    SpendsByCategories,
    DashboardStats,
    DashboardCards,
    DashboardData,
} from "@js/types/interfaces";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useDashboardStore = defineStore("dashboardStore", () => {
    const selectedCard = ref<string>("");
    const transfers = ref<DashboardTransfers[]>([]);
    const favourites = ref<DashboardFavourites[]>([]);
    const incomes = ref<DashboardIncome>();
    const spendsByCategories = ref<SpendsByCategories>();
    const statistics = ref<DashboardStats[]>();
    const creditCards = ref<DashboardCards[]>();
    const accountsData = ref<DashboardData[]>();

    const changeStore = (id: number = 0) => {
        if (!accountsData.value) return;

        selectedCard.value = accountsData.value[id].cardNumber;
        transfers.value = accountsData.value[id].transfers;
        favourites.value = accountsData.value[id].favourites;
        incomes.value = accountsData.value[id].incomes;
        spendsByCategories.value = accountsData.value[id].spendsByCategories;
        statistics.value = accountsData.value[id].statistics;
    };

    return {
        selectedCard,
        transfers,
        favourites,
        incomes,
        spendsByCategories,
        statistics,
        creditCards,
        accountsData,
        changeStore,
    };
});
