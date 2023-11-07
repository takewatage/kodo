<script setup lang="ts">
import variables from '../../sass/variables.module.scss'
import { usePage, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { ILink } from '@/types'
import { useLink } from '@/composables/useLink'

const { headerHeight } = variables
const page = usePage()
const { goLink } = useLink()

const props = defineProps<{
    menu: ILink[]
}>()

const tabValue = ref(route().current())

const items: ILink[] = [
    {
        title: 'プロフィール',
        href: 'profile',
    },
    {
        title: 'ニュース',
        href: 'news',
    },
    {
        title: 'ログアウト',
        href: 'logout',
        method: 'post',
    },
]
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
                :key="link.title"
                :text="link.title"
                :value="link.href"
                @click="goLink(link)"
            ></v-tab>
        </v-tabs>
        <v-spacer></v-spacer>

        <v-menu
            width="260"
            transition="scale-transition"
        >
            <template #activator="{ props }">
                <v-btn
                    icon
                    v-bind="props"
                >
                    <v-avatar
                        class="hidden-sm-and-down"
                        color="success"
                        size="32"
                    ></v-avatar>
                </v-btn>
            </template>

            <v-list>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    class="focus:outline-none"
                    :title="item.title"
                    color="primary"
                    @click="goLink(item)"
                >
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>

<style lang="scss" scoped></style>
