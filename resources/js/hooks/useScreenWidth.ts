import { ref, onMounted, onUnmounted } from "vue";

function useWindowWidth() {
    const width = ref(window.innerWidth);

    const updateWidth = () => {
        width.value = window.innerWidth;
    };

    onMounted(() => {
        window.addEventListener("resize", updateWidth);
    });

    onUnmounted(() => {
        window.removeEventListener("resize", updateWidth);
    });

    return width;
}

export default useWindowWidth;
