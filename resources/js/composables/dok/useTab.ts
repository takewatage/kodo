import { ref } from 'vue'

const tab = ref(null)

export const useTab = () => {
    return {
        tab,
    }
}
