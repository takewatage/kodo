<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import SideColumn from '@/Components/SideColumn.vue'
import CardList from '@/Components/CardList.vue'
import PostCard from '@/Components/PostCard.vue'
import { ref } from 'vue'
import Post from '@/models/Post'
import PaginationModel, { ILink } from '@/models/Paginate'
import AppPagination from '@/Components/AppPagination.vue'

const props = defineProps<{
    posts: PaginationModel<Post>
}>()

const postPaginate = ref(new PaginationModel(props.posts, Post))

const goLink = (pageNum: ILink) => {
    if (pageNum.url) {
        router.get(pageNum.url)
    }
}
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <v-container>
            <v-row>
                <SideColumn :width="250" />

                <v-col
                    cols="12"
                    md
                >
                    <CardList>
                        <template
                            v-for="post in postPaginate.data"
                            :key="post.id"
                        >
                            <PostCard :post="post" />
                        </template>
                    </CardList>
                </v-col>
            </v-row>
            <AppPagination
                :page="postPaginate.currentPage"
                :links="postPaginate.links"
                @change="goLink"
            />
        </v-container>
    </AuthenticatedLayout>
</template>
