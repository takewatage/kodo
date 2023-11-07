import { ILink } from '@/types'
import { router } from '@inertiajs/vue3'

export const useLink = () => {
    const linkMethods: any = {
        post: (href: string) => {
            router.post(href)
        },
        get: (href: string) => {
            router.get(href)
        },
    }
    const goLink = (item: ILink) => {
        console.log(item)
        if (!item.method) {
            return router.visit(item.href)
        }
        linkMethods[item.method](item.href)
    }

    return { goLink }
}
