<script setup lang="ts">
import { ref } from 'vue'
import { ILink } from '@/models/Paginate'
import { useToString } from '@vueuse/core'

const emits = defineEmits<{
    (e: 'next', pageNum: number): void
    (e: 'prev', pageNum: number): void
    (e: 'change', link: ILink): void
}>()

const props = withDefaults(
    defineProps<{
        page?: number
        links: ILink[]
    }>(),
    {
        page: 1,
    }
)

const innerPage = ref(props.page)
console.log(props.links)
const next = (num: number) => {
    emits('next', num)
}
const prev = (num: number) => {
    emits('prev', num)
}

const change = (num: number) => {
    console.log('change:' + num)
    console.log(useToString(num).value)
    const link = props.links.find((x) => {
        return x.label === useToString(num).value
    })
    console.log(link)
    emits('change', link as ILink)
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
