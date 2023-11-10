<script setup lang="ts">
import variables from '../../sass/variables.module.scss'
import { usePage, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { ILink } from '@/types'
import { useLink } from '@/composables/useLink'
import AppHeaderMenuIcon from '@/Components/AppHeaderMenuIcon.vue'
import PostEditDialog from '@/Components/PostEditDialog.vue'

const { headerHeight } = variables
const page = usePage()
const { goLink } = useLink()

const props = defineProps<{
    menu: ILink[]
}>()

const dialog = ref(false)

const tabValue = ref(route().current())
</script>

<template>
    <v-app-bar
        class="px-3"
        :height="headerHeight"
    >
        <Link href="/">
            <h3 class="font-weight-bold">
                {{ page.props.appName }}
            </h3>
        </Link>

        <v-spacer></v-spacer>

        <v-tabs
            class="mt-auto"
            centered
            color="primary"
            v-model="tabValue"
        >
            <v-tab
                v-for="link in menu"
                :key="link.title + '_tab'"
                :text="link.title ?? ''"
                :value="link.href"
                @click="goLink(link)"
            ></v-tab>
        </v-tabs>
        <v-spacer></v-spacer>

        <p>pp: {{ dialog }}</p>

        <AppHeaderMenuIcon />

        <v-btn
            color="primary"
            variant="flat"
            @click="dialog = true"
        >
            投稿
        </v-btn>

        <PostEditDialog v-model:active="dialog" />
    </v-app-bar>
</template>

<style lang="scss"></style>
