<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CardList from '@/Components/CardList.vue'
import PostCard from '@/Components/PostCard.vue'
import { ref } from 'vue'
import Post from '@/models/Post'
import PaginationModel from '@/models/Paginate'
import AppPagination from '@/Components/AppPagination.vue'
import { useLink } from '@/composables/useLink'

const props = defineProps<{
    posts: PaginationModel<Post>
}>()
defineOptions({ layout: AuthenticatedLayout })
const { goLink } = useLink()

const postPaginate = ref(new PaginationModel(props.posts, Post))
</script>

<template>
    <Head title="Group Posts" />

    <v-container>
        <v-row>
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
            @change="(link) => goLink(link)"
        />
    </v-container>
</template>
