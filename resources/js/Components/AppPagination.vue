<script setup lang="ts">
import { ref } from 'vue'
import { IPaginateLink } from '@/models/Paginate'
import { useToString } from '@vueuse/core'
import { ILink } from '@/types'

const emits = defineEmits<{
    (e: 'next', pageNum: number): void
    (e: 'prev', pageNum: number): void
    (e: 'change', link: ILink): void
}>()

const props = withDefaults(
    defineProps<{
        page?: number
        links: IPaginateLink[]
    }>(),
    {
        page: 1,
    }
)

const innerPage = ref(props.page)
const next = (num: number) => {
    emits('next', num)
}
const prev = (num: number) => {
    emits('prev', num)
}

const change = (num: number) => {
    const link: IPaginateLink | undefined = props.links.find((x) => {
        return x.label === useToString(num).value
    })
    if (!link) return
    const linkObj = { href: link.url }
    emits('change', linkObj as ILink)
}
</script>

<template>
    <div
        v-if="props.links.length > 3"
        class="max-width"
    >
        <v-pagination
            v-model="innerPage"
            class="my-4"
            :length="props.links.length - 2"
            @next="next"
            @prev="prev"
            @update:model-value="change"
        >
        </v-pagination>
    </div>
</template>

<style lang="scss" scoped></style>
