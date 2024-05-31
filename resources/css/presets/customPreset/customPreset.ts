import { usePassThrough } from "primevue/passthrough";
import Aura from "../aura";

const CustomPreset = usePassThrough(
    Aura,
    {
        steps: {
            action: {
                class: ["bg-transparent"],
            },
        },
    },
    {
        mergeSections: true,
        mergeProps: true,
    }
);

export default CustomPreset;
