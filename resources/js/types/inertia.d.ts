import { PageProps as InertiaPageProps } from "@inertiajs/inertia";

interface User {
    id: number;
    name: string;
    email: string;
    surname: string;
}

declare module "@inertiajs/inertia" {
    interface PageProps extends InertiaPageProps {
        auth: {
            user: User;
        };
    }
}
