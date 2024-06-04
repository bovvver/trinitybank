import { InertiaForm } from "@inertiajs/vue3";
import BankingProduct from "@js/enums/BankingProduct";

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
