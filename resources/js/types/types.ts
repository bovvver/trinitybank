import Method from "@js/enums/HttpMethods";

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

export type ToastSeverity =
    | "success"
    | "info"
    | "warn"
    | "error"
    | "secondary"
    | "contrast"
    | undefined;

export type CardColors = "Blue" | "Yellow" | "Purple" | "Green";
