import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import PrimeVue from "primevue/config";
import Ripple from "primevue/ripple";
import CustomPreset from "../css/presets/customPreset/customPreset";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faPiggyBank } from "@fortawesome/free-solid-svg-icons";
import { faArrowTrendUp } from "@fortawesome/free-solid-svg-icons";
import { faArrowTrendDown } from "@fortawesome/free-solid-svg-icons";

library.add(faPiggyBank);
library.add(faArrowTrendUp);
library.add(faArrowTrendDown);

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const primeVueOptions = {
    ripple: true,
    unstyled: true,
    pt: CustomPreset,
};

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .component("font-awesome-icon", FontAwesomeIcon)
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, primeVueOptions)
            .directive("ripple", Ripple)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
