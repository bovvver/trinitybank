import { InertiaForm } from "@inertiajs/vue3";
import { Currency } from "@js/enums/Currency";
import Method from "@js/enums/HttpMethods";

export type CardLoginForm = InertiaForm<{
    card_number: string;
    cvv_number: number;
    expiry_date: string;
}>;

export type UserDataErrors = Partial<
    Record<
        | "name"
        | "surname"
        | "email"
        | "password"
        | "password_confirmation"
        | "ssn_number"
        | "phone_number"
        | "city"
        | "zip_code"
        | "street"
        | "house_number"
        | "banking_product",
        string
    >
>;

export type MenuItem = {
    name: string;
    icon: string;
};

export type SubItem = {
    name: string;
    route: string;
    method?: Method;
};

export type MenuItems = {
    account: SubItem[];
    loans: SubItem[];
    stats: SubItem[];
    profile: SubItem[];
};

export interface DashboardTransfers {
    message: string;
    amount: string;
    currency: keyof typeof Currency;
    transactionDate: string;
    fullName: string;
    isSender: boolean;
}

export interface DashboardFavourites {
    fullName: string;
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
    cardNumber: string;
    transfers: DashboardTransfers[];
    favourites: DashboardFavourites[];
    incomes: DashboardIncome;
    spendsByCategories: SpendsByCategories;
    statistics: DashboardStats[];
}

export interface PageProps {
    accountsData: DashboardData[];
    cards: DashboardCards[];
}
