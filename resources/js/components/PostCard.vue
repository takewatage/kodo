<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Post from '@/models/Post'

defineProps<{
    post: Post
}>()
</script>

<template>
    <div class="post-card mb-5">
        <div class="post-card__header d-flex align-content-center">
            <v-avatar color="primary" />
            <div>
                <Link
                    href="#"
                    class="text-white">
                    <p>{{ post.user.urlName }}</p>
                </Link>
                <span>{{ post.createdAtDisplay }}</span>
            </div>
        </div>
        <div class="post-card__body">
            <h3 class="mt-2">{{ post.title }}</h3>
            <p class="text-pre-wrap mt-2">{{ post.content }}</p>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use '/resources/sass/variables.module';
.post-card {
    background: rgba(var(--v-theme-surface));
    border-radius: 10px;
    padding: 15px;

    &__header {
        gap: 15px;
        font-size: variables.$font-body1;

        span {
            font-size: variables.$font-small;
        }
    }

    &__body {
        margin-left: 55px;
    }

    &__title {
    }
}
</style>
