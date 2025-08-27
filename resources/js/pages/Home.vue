<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
// import Post from '@/models/Post'
import { router } from '@inertiajs/vue3'

// const props = defineProps<{
//     posts: PaginationModel<Post>
// }>()

defineOptions({ layout: AuthenticatedLayout })

// const postPaginate = ref(new PaginationModel(props.posts, Post))
</script>

<template>
    <v-container>
        <button @click="router.get('dok')">dok</button>
    </v-container>
</template>
