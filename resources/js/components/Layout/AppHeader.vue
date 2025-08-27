<script setup lang="ts">
import variables from '../../../sass/variables.module.scss'
import { usePage, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppHeaderMenuIcon from '@/components/layout/AppHeaderMenuIcon.vue'
import PostEditDialog from '@/components/PostEditDialog.vue'

const { headerHeight } = variables
const page = usePage()

const dialog = ref(false)

const tabValue = ref(route().current())
</script>

<template>
    <v-app-bar
        class="px-3"
        :height="headerHeight">
        <Link href="/">
            <h3 class="font-weight-bold">
                {{ page.props.appName }}
            </h3>
        </Link>

        <v-spacer></v-spacer>

        <v-tabs
            v-model="tabValue"
            class="mt-auto"
            centered
            color="primary">
            <v-tab
                v-for="link in menu"
                :key="link.title + '_tab'"
                :text="link.title ?? ''"
                :value="link.href"></v-tab>
        </v-tabs>
        <v-spacer></v-spacer>

        <AppHeaderMenuIcon />

        <v-btn
            color="primary"
            variant="flat"
            @click="dialog = true">
            投稿
        </v-btn>

        <PostEditDialog v-model:active="dialog" />
    </v-app-bar>
</template>

<style lang="scss"></style>
