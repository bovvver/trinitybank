import { ToastSeverity } from "@js/types/types";
import { ToastServiceMethods } from "primevue/toastservice";
import { NewCardDropdownOptions } from "@js/types/interfaces";
import { Currency } from "@js/enums/Currency";

// DATE HELPERS

export const formatDate = (date: Date) => {
    const msDiff = new Date().getTime() - date.getTime();

    const minutesDiff = Math.floor(msDiff / (1000 * 60));
    const hoursDiff = Math.floor(msDiff / (1000 * 60 * 60));
    const daysDiff = Math.floor(msDiff / (1000 * 60 * 60 * 24));

    if (minutesDiff <= 1) return "A moment ago";
    else if (minutesDiff < 60) return `${minutesDiff} minutes ago`;
    else if (hoursDiff < 24) return `${hoursDiff} hour(s) ago`;
    else if (daysDiff == 1) return "Yesterday";
    else if (daysDiff < 7) return `${daysDiff} days ago`;
    else return date.toDateString().split(" ").slice(1).join(" ");
};

export const getDateDaysAgo = (days: number) => {
    const date = new Date();
    date.setDate(date.getDate() - days);
    return date;
};

// MONEY HELPERS

export const displayCorrectAmount = (amount: number, isPositive: boolean) => {
    if (isPositive) return `${amount}`;
    return `-${amount}`;
};

export const currencyOptions: NewCardDropdownOptions[] = Object.entries(
    Currency
).map(([name, sign]) => ({
    name: `${name} (${sign})`,
    value: name,
}));

// TOAST

export const showToast = (
    toast: ToastServiceMethods,
    severity: ToastSeverity,
    summary: string,
    detail: string
) => {
    toast.add({ severity, summary, detail, life: 5000 });
};

// AVATAR

export const getFinalAvatarUrl = (avatarUrl: string) => {
    if (!avatarUrl) return "";
    return `storage/${avatarUrl}`;
};
