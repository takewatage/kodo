<script setup lang="ts">
import { useLink } from '@/composables/useLink'
import { ILink } from '@/types'

const { goLink } = useLink()
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
    <v-menu
        width="260"
        transition="scale-transition">
        <template #activator="{ props }">
            <v-btn
                icon
                v-bind="props">
                <v-avatar
                    class="hidden-sm-and-down"
                    color="success"
                    size="32"></v-avatar>
            </v-btn>
        </template>

        <v-list>
            <v-list-item
                v-for="item in items"
                :key="item.title + '_menu'"
                class="focus:outline-none"
                :title="item.title ?? ''"
                color="primary"
                @click="goLink(item)">
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<style lang="scss" scoped></style>
