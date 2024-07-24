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
        avatar: {
            image: [
                "h-full w-full rounded-full h-full w-full rounded-full object-cover",
            ],
        },
    },
    {
        mergeSections: true,
        mergeProps: true,
    }
);

export default CustomPreset;
