import axios from "axios";
import { CardColors } from "@js/types/types";
import { InertiaForm } from "@inertiajs/vue3";
import { TransferProps } from "@js/types/interfaces";

export const makeTransfer = async (form: InertiaForm<TransferProps>) => {
    return await axios.post(route("make-transfer"), form);
};

export const setSelectedAccount = async (newColor: CardColors, newStatus: boolean, cardDigits: string) => {
    return await axios.patch(route("update-card"), { newColor, newStatus, cardDigits });
};
