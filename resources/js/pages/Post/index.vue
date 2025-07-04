<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'

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
