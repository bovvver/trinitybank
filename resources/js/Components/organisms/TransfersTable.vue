<script setup lang="ts">
import TransferStatus from "@js/enums/TransferStatus";
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { reactive, ref } from "vue";
import { formatDate } from "@js/helpers/helpers";
import Tag from "primevue/tag";
import { TransferDetails } from "@js/types/interfaces";
import { FilterMatchMode } from "primevue/api";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import TransferDetailsDialog from "@js/Components/molecules/TransferDetailsDialog.vue";
import Categories from "@js/enums/Categories";

defineProps<{
    rows: number;
    class?: string;
}>();

const getYesterdayDate = (days: number) => {
    // TODO: FOR REMOVAL IN LATER STAGES OF DEVLOPMENT
    const date = new Date();
    date.setDate(date.getDate() - days);
    return date;
};

const dt = ref();
const products = ref<TransferDetails[]>([
    {
        target: "John Travolta",
        cardNumber: "1234",
        description: "Here you go",
        amount: "1020.00",
        currency: "USD",
        date: new Date(),
        category: Categories.INVESTMENTS,
        status: TransferStatus.SEND,
    },
    {
        target: "Mary Smith",
        cardNumber: "8821",
        description: "Im returning your money",
        amount: "500.00",
        currency: "EUR",
        date: getYesterdayDate(1),
        category: Categories.WORK,
        status: TransferStatus.RECEIVED,
    },
    {
        target: "Bob Builder",
        cardNumber: "7728",
        description: "I like cars",
        amount: "5200.00",
        currency: "EUR",
        date: getYesterdayDate(10),
        category: Categories.TRANSPORT,
        status: TransferStatus.RECEIVED,
    },
]);

const searchFilter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    target: { value: null, matchMode: FilterMatchMode.CONTAINS },
    cardNumber: { value: null, matchMode: FilterMatchMode.CONTAINS },
    amount: { value: null, matchMode: FilterMatchMode.CONTAINS },
    currency: { value: null, matchMode: FilterMatchMode.CONTAINS },
    date: { value: null, matchMode: FilterMatchMode.DATE_IS },
    status: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const selectedRow = reactive<TransferDetails>({
    target: "",
    cardNumber: "",
    description: "",
    amount: "",
    currency: "",
    date: "",
    category: Categories.OTHERS,
    status: TransferStatus.SEND,
});
const visible = ref(false);

const getSeverity = (transfer: TransferDetails) => {
    switch (transfer.status) {
        case TransferStatus.RECEIVED:
            return "success";
        case TransferStatus.SEND:
            return "warning";
    }
};

const exportCSV = (_e: MouseEvent) => {
    dt.value.exportCSV();
};

const onRowSelect = (e: DataTableRowClickEvent) => {
    e.data.date = formatDate(e.data.date);
    Object.assign(selectedRow, e.data);
    visible.value = true;
};

const updateVisible = (value: boolean) => {
    visible.value = value;
};
</script>

<template>
    <DataTable
        stripedRows
        paginator
        removableSort
        ref="dt"
        :rows="rows"
        :value="products"
        v-model:filters="searchFilter"
        selectionMode="single"
        tableStyle="min-width: 42rem"
        @rowSelect="onRowSelect"
        :class="class"
    >
        <template #header>
            <div class="flex justify-between">
                <Button
                    icon="pi pi-external-link"
                    label="Export"
                    @click="exportCSV($event)"
                />
                <span class="relative">
                    <i class="search-icon pi pi-search" />
                    <InputText
                        v-model="searchFilter['global'].value"
                        placeholder="Keyword Search"
                        class="pl-10 font-normal"
                    />
                </span>
            </div>
        </template>
        <template #empty>No transfers found.</template>
        <Column field="target" header="To/From" sortable></Column>
        <Column #body="slotProps" field="cardNumber" header="Card number">
            {{ `**** ${slotProps.data.cardNumber}` }}
        </Column>
        <Column field="amount" header="Amount" sortable></Column>
        <Column field="currency" header="Currency" sortable></Column>
        <Column #body="slotProps" field="date" header="Date" sortable>
            {{ formatDate(slotProps.data.date) }}
        </Column>
        <Column #body="slotProps" field="status" header="Status" sortable>
            <Tag
                :value="slotProps.data.status"
                :severity="getSeverity(slotProps.data)"
            />
        </Column>
    </DataTable>
    <TransferDetailsDialog
        :visible="visible"
        :data="selectedRow"
        @close="updateVisible(false)"
        @update:visible="updateVisible"
    />
</template>

<style scoped lang="scss">
.search-icon {
    @apply absolute top-2/4 -mt-2 left-3 text-surface-400 dark:text-surface-600;
}
</style>
