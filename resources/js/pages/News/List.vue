<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <v-pagination
            class="my-4"
            :length="15"></v-pagination>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3">
                                        タイトル
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3">
                                        コンテンツ
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3">
                                        更新日
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3">
                                        作成日
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        test
                                    </th>
                                    <td class="px-6 py-4">test</td>
                                    <td class="px-6 py-4">2023/11/2</td>
                                    <td class="px-6 py-4">2023/11/2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
