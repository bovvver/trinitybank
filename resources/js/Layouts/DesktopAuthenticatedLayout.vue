<script setup lang="ts">
import { ref } from "vue";
import Menu from "primevue/menu";
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import Avatar from "primevue/avatar";
import { Link } from "@inertiajs/vue3";
import Method from "@js/enums/HttpMethods";
import Tag from "primevue/tag";

const ptStyles = ref({
    root: "sticky bottom-0 top-0 left-0 bg-neutral-950 rounded-r-2xl px-3 w-1/6 h-screen w-[20%] ",
    submenuHeader: "bg-neutral-950 py-3 px-3 font-bold text-primary uppercase",
    content:
        "overflow-hidden flex items-center hover:bg-neutral-900 rounded-md cursor-pointer transition",
    end: "text-white hover:bg-neutral-900 rounded-md absolute bottom-4 right-3 left-3 transition",
    separator: "my-5 mx-2 bg-neutral-900 h-[1px]",
});

const items = ref([
    {
        label: "Account",
        items: [
            {
                label: "History",
                icon: "pi pi-history",
                route: "history",
                soon: false,
            },
            {
                label: "Cards",
                icon: "pi pi-credit-card",
                route: "cards",
                soon: false,
            },
            {
                label: "Transfer",
                icon: "pi pi-arrow-right-arrow-left",
                route: "transfer",
                soon: false,
            },
        ],
    },
    {
        label: "Loans",
        items: [
            {
                label: "Current Loans",
                icon: "pi pi-ticket",
                route: "dashboard",
                soon: true,
            },
            {
                label: "Apply for Loan",
                icon: "pi pi-briefcase",
                route: "dashboard",
                soon: true,
            },
            {
                label: "Loan Calculators",
                icon: "pi pi-calculator",
                route: "dashboard",
                soon: true,
            },
        ],
    },
    {
        label: "Stats",
        items: [
            {
                label: "Details",
                icon: "pi pi-chart-bar",
                route: "dashboard",
                soon: true,
            },
        ],
    },
    {
        separator: true,
    },
    {
        label: "Logout",
        icon: "pi pi-sign-out",
        route: "logout",
        method: Method.POST,
    },
]);
</script>

<template>
    <div class="layout-wrapper">
        <Menu :model="items" :pt="ptStyles">
            <template #start>
                <div class="layout-wrapper__logo">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo :size="130" color="#fff" />
                    </Link>
                </div>
            </template>
            <template #submenuheader="{ item }">
                <span>{{ item.label }}</span>
            </template>
            <template #item="{ item, props }">
                <Link
                    as="button"
                    :href="route(item.route)"
                    :method="item.method ?? Method.GET"
                    class="w-full text-white"
                    v-ripple
                    v-bind="props.action"
                >
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                    <Tag v-if="item.soon" value="SOON" severity="contrast" class="ml-5" />
                </Link>
            </template>
            <template #end>
                <Link
                    :href="route('profile')"
                    v-ripple
                    class="flex items-center w-full p-2"
                    as="button"
                >
                    <Avatar
                        :label="$page.props.auth.user.name.charAt(0)"
                        class="mr-2"
                        shape="circle"
                    />
                    <span>
                        <span class="font-bold">{{
                            $page.props.auth.user.name
                        }}</span>
                    </span>
                </Link>
            </template>
        </Menu>
        <slot />
    </div>
</template>

<style scoped lang="scss">
.layout-wrapper {
    @apply flex;

    &__logo {
        @apply flex flex-col justify-center items-center py-10;
    }
}
</style>
