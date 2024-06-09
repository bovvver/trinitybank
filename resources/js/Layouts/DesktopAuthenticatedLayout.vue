<script setup lang="ts">
import { ref } from "vue";
import Menu from "primevue/menu";
import ApplicationLogo from "@js/Components/atoms/ApplicationLogo.vue";
import Avatar from "primevue/avatar";

const ptStyles = ref({
    root: "relative bg-neutral-950 rounded-r-2xl px-3 w-1/6 h-screen min-w-[320px]",
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
            },
            {
                label: "Cards",
                icon: "pi pi-credit-card",
            },
            {
                label: "Transfer",
                icon: "pi pi-arrow-right-arrow-left",
            },
        ],
    },
    {
        label: "Loans",
        items: [
            {
                label: "Current Loans",
                icon: "pi pi-ticket",
            },
            {
                label: "Apply for Loan",
                icon: "pi pi-briefcase",
            },
            {
                label: "Loan Calculators",
                icon: "pi pi-calculator",
            },
        ],
    },
    {
        label: "Stats",
        items: [
            {
                label: "Details",
                icon: "pi pi-chart-bar",
            },
        ],
    },
    {
        separator: true,
    },
    {
        label: "Logout",
        icon: "pi pi-sign-out",
    },
]);
</script>

<template>
    <div class="layout-wrapper">
        <Menu :model="items" :pt="ptStyles">
            <template #start>
                <div class="layout-wrapper__logo">
                    <ApplicationLogo :size="130" color="#fff" />
                </div>
            </template>
            <template #submenuheader="{ item }">
                <span>{{ item.label }}</span>
            </template>
            <template #item="{ item, props }">
                <a class="w-full text-white" v-ripple v-bind="props.action">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                </a>
            </template>
            <template #end>
                <button v-ripple class="flex items-center w-full p-2">
                    <Avatar
                        image="https://ichef.bbci.co.uk/images/ic/1200x675/p08rkqxl.jpg"
                        class="mr-2"
                        shape="circle"
                    />
                    <span>
                        <span class="font-bold">Bob Builder</span>
                    </span>
                </button>
            </template>
        </Menu>
        <slot />
    </div>
</template>

<style scoped lang="scss">
.layout-wrapper {
    @apply min-h-screen flex;

    &__logo {
        @apply flex flex-col justify-center items-center py-10;
    }
}
</style>
