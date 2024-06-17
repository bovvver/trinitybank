import { InertiaForm } from "@inertiajs/vue3";
import BankingProduct from "@js/enums/BankingProduct";
import Categories from "@js/enums/Categories";
import { Currency } from "@js/enums/Currency";
import TransferStatus from "@js/enums/TransferStatus";

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

export interface DashboardTransfers {
    message: string;
    amount: string;
    currency: keyof typeof Currency;
    transactionDate: string;
    fullName: string;
    isSender: boolean;
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

export interface TransferDetails {
    target: string;
    cardNumber: string;
    description: string;
    amount: string;
    currency: string;
    date: string | Date;
    category: Categories;
    status: TransferStatus;
}