<script setup lang="ts">
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import { ref } from "vue";
import useWindowWidth from "@js/hooks/useScreenWidth";
import { MenuItem, MenuItems } from "@js/types/types";
import { Link } from "@inertiajs/vue3";
import Method from "@js/enums/HttpMethods";

const width = useWindowWidth();

const selectedItem = ref<keyof MenuItems | null>(null);
const unfolded = ref(false);

const items = ref<MenuItem[]>([
    {
        name: "account",
        icon: "pi pi-credit-card",
    },
    {
        name: "loans",
        icon: "pi pi-briefcase",
    },
    {
        name: "stats",
        icon: "pi pi-chart-bar",
    },
    {
        name: "profile",
        icon: "pi pi-user",
    },
]);

const unfoldedItems = ref<MenuItems>({
    account: [
        {
            name: "History",
            route: "history",
        },
        {
            name: "Cards",
            route: "cards",
        },
        {
            name: "Transfer",
            route: "transfer",
        },
    ],
    loans: [
        {
            name: "Current Loans",
            route: "dashboard",
        },
        {
            name: "Apply for Loan",
            route: "dashboard",
        },
        {
            name: "Loan Calculators",
            route: "dashboard",
        },
    ],
    stats: [
        {
            name: "Details",
            route: "dashboard",
        },
    ],
    profile: [
        {
            name: "Profile",
            route: "profile",
        },
        {
            name: "Logout",
            route: "logout",
            method: Method.POST,
        },
    ],
});

const selectItem = (item: keyof MenuItems) => {
    selectedItem.value = item;
    unfolded.value = true;
};
</script>

<template>
    <div class="mobile-authenticated-layout">
        <div class="mobile-authenticated-layout__nav">
            <ApplicationLogo
                v-if="width > 640"
                :size="50"
                color="#fff"
                class="mobile-authenticated-layout__logo"
            />
            <button
                v-for="item in items"
                class="mobile-authenticated-layout__link"
                @click="() => selectItem(item.name as keyof MenuItems)"
            >
                <span :class="item.icon" />
            </button>
        </div>
        <div
            class="mobile-authenticated-layout__unfolded-nav"
            :class="{ unfolded: selectedItem }"
        >
            <Link
                :href="route(subItem.route)"
                as="button"
                :method="subItem.method ?? Method.GET"
                v-if="selectedItem"
                v-for="subItem in unfoldedItems[selectedItem]"
                :key="subItem.name"
            >
                {{ subItem.name }}
            </Link>
        </div>
        <slot />
    </div>
</template>

<style scoped lang="scss">
.mobile-authenticated-layout {
    @apply h-screen relative overflow-hidden;

    &__nav {
        @apply fixed bottom-0 w-screen bg-neutral-950 h-20 rounded-t-3xl flex items-center justify-evenly z-10;
    }

    &__link {
        @apply text-white cursor-pointer text-xl w-12 aspect-square flex items-center justify-center rounded-full hover:bg-neutral-900 transition;
    }

    &__logo {
        @apply absolute inset-x-1/2 -translate-x-1/2;
    }

    &__unfolded-nav {
        @apply absolute bottom-0 inset-x-1/2 w-11/12 md:w-4/5 h-[150px] flex p-4 justify-evenly items-start bg-neutral-900 transition-transform rounded-t-3xl -translate-x-1/2 translate-y-full;

        button {
            @apply text-white font-bold cursor-pointer uppercase hover:bg-neutral-800 transition p-2 rounded text-center text-sm sm:text-base;
        }
    }
}

.unfolded {
    @apply -translate-y-2 sm:translate-y-0;
}
</style>
