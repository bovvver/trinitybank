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

export interface Transfer {
    message: string;
    amount: string;
    currency: keyof typeof Currency;
    transactionDate: string;
    fullName: string;
    isSender: boolean;
}

export interface PageProps {
    transfers: Transfer[];
}
