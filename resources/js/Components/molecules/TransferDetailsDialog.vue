<script setup lang="ts">
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import TransferDetailsDialogCell from "@js/Components/atoms/TransferDetailsDialogCell.vue";
import { TransferDetails } from "@js/types/interfaces";
import { formatDate } from "@js/helpers/helpers";

defineProps<{
    data: TransferDetails;
    visible: boolean;
}>();

const emit = defineEmits(['update:visible', 'close']);

const updateVisible = (value: boolean) => {
    emit('update:visible', value);
};

const confirmDateType = (date: string | Date) => {
    if(date instanceof Date) return formatDate(date);
    return date;
}
</script>

<template>
    <Dialog
        :visible="visible"
        @update:visible="updateVisible"
        modal
        header="Transfer Details"
        class="w-[20rem]"
    >
        <TransferDetailsDialogCell title="Target" :content="data.target" />
        <TransferDetailsDialogCell title="Card number" :content="`**** ${data.cardNumber}`" />
        <TransferDetailsDialogCell title="Description" :content="data.description" />
        <TransferDetailsDialogCell title="Amount" :content="data.amount" />
        <TransferDetailsDialogCell title="Currency" :content="data.currency" />
        <TransferDetailsDialogCell title="Date" :content="confirmDateType(data.date)" />
        <TransferDetailsDialogCell title="Category" :content="data.category" />
        <TransferDetailsDialogCell title="Status" :content="data.status" />
        <div class="dialog-button">
            <Button type="button" label="OK" @click="emit('close')" />
        </div>
    </Dialog>
</template>

<style scoped>
.dialog-button {
    @apply flex justify-end;
}
</style>
