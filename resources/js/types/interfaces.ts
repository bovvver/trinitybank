import { InertiaForm } from "@inertiajs/vue3";
import BankingProduct from "@js/enums/BankingProduct";
import { Currency } from "@js/enums/Currency";
import { ToastServiceMethods } from "primevue/toastservice";

export type RegistrationForm = InertiaForm<{
    name: string;
    surname: string;
    email: string;
    password: string;
    password_confirmation: string;
    ssn_number: string;
    phone_number: string;
    city: string;
    zip_code: string;
    street: string;
    house_number: string;
    banking_product: BankingProduct;
}>;

export interface DashboardFavourites {
    fullName: string;
    accountNumber: string;
}

export interface TransferData {
    message: string;
    amount: string;
    currency: keyof typeof Currency;
    transactionDate: string;
    fullName: string;
    isSender: boolean;
    category: string;
    cardNumber: string;
}

export interface DashboardIncome {
    todayIncome: string;
    monthIncome: string;
    monthSpend: string;
}

export interface SpendsByCategories {
    education?: string;
    food?: string;
    hygiene?: string;
    transport?: string;
    work?: string;
    investments?: string;
    others?: string;
}

export interface DashboardStats {
    month: string;
    spends: string | number;
    incomes: string | number;
}

export interface DashboardCards {
    cardLastDigits: string;
    balance: string;
    currency: string;
}

export interface DashboardData {
    id: number;
    cardNumber: string;
    transfers: TransferData[];
    favourites: DashboardFavourites[];
    incomes: DashboardIncome;
    spendsByCategories: SpendsByCategories;
    statistics: DashboardStats[];
}

export interface DashboardProps {
    accountsData: DashboardData[];
    cards: DashboardCards[];
    selectedCard: number;
}

export interface TransferFormProps {
    cards: DashboardCards[];
    favourites: DashboardFavourites[];
}

export interface HistoryProps {
    history: HistoryTransfer;
}

export interface TransferDetails {
    fullName: string;
    accountNumber: string;
    message: string;
    amount: string;
    currency: string;
    transactionDate: string | Date;
    category: string;
    isSender: boolean;
}

export interface NewCardDetails {
    currency: string | null;
    banking_product: BankingProduct;
}

export interface NewCardDropdownOptions {
    name: string;
    value: string;
}

export interface ProfileDataOption {
    key: string;
    value: string | number;
    hidden: boolean;
    isVisible: boolean;
    editable?: boolean;
}

export interface HistoryTransfer {
    data: TransferData[];
    meta: {
        current_page: number;
        total: number;
        from?: number;
        last_page?: number;
        per_page?: number;
        to?: number;
    };
}

export interface Errors {
    receiver: string;
    message: string;
    category: string;
    sender_card: string;
    account_number: string;
    amount: string;
    currency: string;
    date: string;
}

type ToastSeverity = "success" | "info" | "warn" | "error" | "secondary" | "contrast" | undefined;

export interface ToastProps {
    toast: ToastServiceMethods;
    severity: ToastSeverity;
    summary: string;
    detail: string;
}
