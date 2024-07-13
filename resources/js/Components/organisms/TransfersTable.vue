<script setup lang="ts">
import Paginator from "primevue/paginator";
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
import { router, usePage } from "@inertiajs/vue3";
import { HistoryProps } from "@js/types/interfaces";

defineProps<{
    class?: string;
}>();

const { history } = usePage().props as Partial<HistoryProps>;

const historyRef = reactive(history ? history.data : []);
const totalRecords = history ? history.meta.total : 0;
const rowsPerPage = 10;

const dt = ref();
const first = ref(0);

const searchFilter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    target: { value: null, matchMode: FilterMatchMode.CONTAINS },
    accountNumber: { value: null, matchMode: FilterMatchMode.CONTAINS },
    amount: { value: null, matchMode: FilterMatchMode.CONTAINS },
    currency: { value: null, matchMode: FilterMatchMode.CONTAINS },
    date: { value: null, matchMode: FilterMatchMode.DATE_IS },
    status: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const selectedRow = reactive<TransferDetails>({
    fullName: "",
    accountNumber: "",
    message: "",
    amount: "",
    currency: "",
    transactionDate: "",
    category: Categories.OTHERS,
    isSender: false,
});
const visible = ref(false);

const getSeverity = (isSender: boolean) => {
    if (isSender) return "warning";
    return "success";
};

const exportCSV = (_e: MouseEvent) => {
    dt.value.exportCSV();
};

const onRowSelect = (e: DataTableRowClickEvent) => {
    e.data.transactionDate = formatDate(new Date(e.data.transactionDate));
    Object.assign(selectedRow, e.data);
    visible.value = true;
};

const updateVisible = (value: boolean) => {
    visible.value = value;
};

const handlePageChange = (event: { page: number }) => {
    const newPage = event.page + 1;
    router.get(route('history', { page: newPage }), {});
}
</script>

<template>
    <DataTable
        stripedRows
        removableSort
        ref="dt"
        :rows="rowsPerPage"
        :value="historyRef"
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
        <Column field="fullName" header="To/From" sortable></Column>
        <Column #body="slotProps" field="accountNumber" header="Account">
            {{ slotProps.data.accountNumber }}
        </Column>
        <Column field="amount" header="Amount" sortable></Column>
        <Column field="currency" header="Currency" sortable></Column>
        <Column
            #body="slotProps"
            field="transactionDate"
            header="Date"
            sortable
        >
            {{ formatDate(new Date(slotProps.data.transactionDate)) }}
        </Column>
        <Column #body="slotProps" field="isSender" header="Status" sortable>
            <Tag
                :value="
                    slotProps.data.isSender
                        ? TransferStatus.SEND
                        : TransferStatus.RECEIVED
                "
                :severity="getSeverity(slotProps.data.isSender)"
            />
        </Column>
    </DataTable>
    <Paginator
        v-model:first="first"
        :rows="rowsPerPage"
        :totalRecords="totalRecords"
        @page="handlePageChange"
    />

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
