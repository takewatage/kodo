<script setup lang="ts">
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()
const appName: string = page.props.appName

interface IItem {
    title: string
    href: string
    method: string
}

const items: IItem[] = [
    {
        title: 'プロフィール',
        href: 'profile',
        method: 'visit',
    },
    {
        title: 'ニュース',
        href: 'news',
        method: 'visit',
    },
    {
        title: 'ログアウト',
        href: 'logout',
        method: 'post',
    },
]

const list = ['ホーム', 'タイムライン', 'メンバーの投稿']

const goPage = (item: IItem) => {
    if (item.method === 'post') {
        return router.post(item.href)
    }
    router.visit(item.href)
}
</script>

<template>
    <v-app>
        <v-app-bar class="px-3">
            <h3 class="font-weight-bold">
                {{ appName }}
            </h3>

            <v-spacer></v-spacer>

            <v-tabs
                class="mt-auto"
                height="50"
                centered
                color="primary"
            >
                <v-tab
                    v-for="link in list"
                    :key="link"
                    :text="link"
                ></v-tab>
            </v-tabs>
            <v-spacer></v-spacer>

            <v-menu
                width="260"
                transition="scale-transition"
            >
                <template v-slot:activator="{ props }">
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
                        class="focus:outline-none"
                        v-for="item in items"
                        :key="item.title"
                        :title="item.title"
                        color="primary"
                        @click="goPage(item)"
                    >
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main>
            <Transition
                name="page"
                mode="out-in"
                appear
            >
                <div :key="$page.url">
                    <slot />
                </div>
            </Transition>
        </v-main>
    </v-app>
</template>

<style lang="scss" scoped>
.page-enter-active,
.page-leave-active {
    transition: all 1s ease-out;
}

.page-enter-from,
.page-leave-to {
    opacity: 0;
}
</style>
