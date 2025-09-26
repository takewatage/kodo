import { reactive } from 'vue'
import { useElementSize } from '@vueuse/core'

export const useHeader = () => {
    const size = reactive(useElementSize(el, { width: 0, height: 0 }, { box: 'border-box' }))

    return {}
}
