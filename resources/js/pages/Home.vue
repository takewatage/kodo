<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import CardList from '@/components/CardList.vue'
import PostCard from '@/components/PostCard.vue'
import { ref } from 'vue'
import Post from '@/models/Post'
import PaginationModel from '@/models/Paginate'
import AppPagination from '@/components/AppPagination.vue'
import { useLink } from '@/composables/useLink'
import { useForm, router } from '@inertiajs/vue3'
import dayjs, { Dayjs } from 'dayjs'

const props = defineProps<{
    posts: PaginationModel<Post>
}>()

defineOptions({ layout: AuthenticatedLayout })

const postPaginate = ref(new PaginationModel(props.posts, Post))

const { goLink } = useLink()

const form = useForm({
    searchData: dayjs().format('YYYY-MM-DD'),
})

const updateData = (val: Dayjs) => {
    form.searchData = val.format('YYYY-MM-DD')
    console.log(form.data())
    router.get('home')
}
</script>

<template>
    <v-container>
        <v-row>
            <v-col
                cols="12"
                md="auto">
                <v-sheet rounded="lg">
                    <v-locale-provider locale="ja">
                        <v-date-picker
                            header="本日"
                            color="primary"
                            width="300"
                            elevation="24"
                            show-adjacent-months
                            @update:model-value="updateData">
                            <template #title />
                        </v-date-picker>
                    </v-locale-provider>
                    <p>{{ dayjs(form.searchData).format('YYYY-M-D') }}</p>
                </v-sheet>
            </v-col>
            <v-col
                cols="12"
                md>
                <CardList>
                    <template
                        v-for="post in postPaginate.data"
                        :key="post.id">
                        <PostCard :post="post" />
                    </template>
                </CardList>
            </v-col>
        </v-row>
        <AppPagination
            :page="postPaginate.currentPage"
            :links="postPaginate.links"
            @change="(link) => goLink(link)" />
    </v-container>
</template>
