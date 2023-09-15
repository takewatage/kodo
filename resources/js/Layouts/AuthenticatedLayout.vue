<script setup lang="ts">
import { ref, Transition } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const drawer = ref(false)
const appName = import.meta.env.VITE_APP_NAME

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

const goPage = (item) => {
    if(item.method === 'post') {
        return router.post(item.href)
    }
    router.visit(item.href)
}

</script>

<template>
    <v-app>
        <v-navigation-drawer v-model="drawer">
            <v-list>
                <v-list-item
                    v-for="item in items"
                    @click="goPage(item)"
                    :title="item.title"
                    :key="item.title"
                    color="primary"
                >
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-app-bar-title>{{ appName }}</v-app-bar-title>

            <Link class="mr-3" :href="route('dashboard')">dashboard</Link>
            <Link class="mr-3" :href="route('profile.edit')">profile</Link>
            <Link class="mr-3" :href="route('news.list')">news</Link><br>

        </v-app-bar>

        <v-main>
            <Transition name="page" mode="out-in" appear>
                <div :key="$page.url">
                    <slot/>
                </div>
            </Transition>
        </v-main>
    </v-app>
</template>

<style>
.page-enter-active,
.page-leave-active {
    transition: all 1s ease-out;
}

.page-enter-from,
.page-leave-to {
    opacity: 0;
}
</style>
