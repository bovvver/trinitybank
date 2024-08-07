import axios from "axios";
import { CardColors } from "@js/types/types";
import { InertiaForm } from "@inertiajs/vue3";
import { TransferProps } from "@js/types/interfaces";
import BankingProduct from "@js/enums/BankingProduct";

export const makeTransfer = async (form: InertiaForm<TransferProps>) => {
    return await axios.post(route("make-transfer"), form);
};

export const setSelectedAccount = async (newColor: CardColors, newStatus: boolean, cardDigits: string) => {
    return await axios.patch(route("update-card"), { newColor, newStatus, cardDigits });
};

export const createNewCard = async (bankingProduct: BankingProduct, currency: string) => {
    return await axios.post(route("create-card"), { bankingProduct, currency });
};

export const updateContact = async (phoneNumber: string, email: string) => {
    return await axios.patch(route("update-contact"), { phoneNumber, email });
};

export const uploadAvatar = async (formData: FormData) => {
    return await axios.post(route("upload-avatar"), formData, {
        headers: {
            "Content-Type": 'multipart/form-data'
        }
    });
};