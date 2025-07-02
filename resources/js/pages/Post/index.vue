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

defineOptions({ layout: AuthenticatedLayout })
</script>

<template>
    <Head title="投稿" />

    <v-container>
        <v-row>
            <v-col
                cols="12"
                md>
                <h2>投稿</h2>
            </v-col>
        </v-row>
    </v-container>
</template>
