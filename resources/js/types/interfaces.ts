import { InertiaForm } from "@inertiajs/vue3";
import BankingProduct from "@js/enums/BankingProduct";
import { Currency } from "@js/enums/Currency";

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

export interface HistoryProps {
    history: HistoryTransfer;
}

export interface TransferDetails {
    fullName: string;
    cardNumber: string;
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

export interface TransferFormOptions {
    name: string;
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
