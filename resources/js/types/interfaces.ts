import { InertiaForm } from "@inertiajs/vue3";
import BankingProduct from "@js/enums/BankingProduct";
import { Currency } from "@js/enums/Currency";
import { CardColors } from "./types";

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
    currency: string;
}>;

export interface DashboardFavourites {
    fullName: string;
    accountNumber: string;
    avatarPath: string;
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
    avatarPath: string;
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
    cardColor: CardColors;
    active?: boolean;
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

export interface PersonalData {
    fullName: string;
    email: string;
    ssnNumber: string;
    phoneNumber: string;
    street: string;
    city: string;
    zipCode: string;
    joined: string;
}

export interface CardsManagerProps {
    cards: DashboardCards[];
    personalData: PersonalData;
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

export interface TransferProps {
    receiver: string;
    message: string;
    category: string;
    sender_card: string;
    account_number: string;
    amount: number;
    currency: string;
    date: Date;
}

export interface ProfileProps {
    personalData: PersonalData;
    cardsCount: number;
    avatarPath: string;
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
