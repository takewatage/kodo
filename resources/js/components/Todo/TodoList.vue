<script setup lang="ts">
import { ref } from 'vue'
import { Category, Task } from '@/types/task'

// const props = defineProps({
//     tasks: [],
//     categories: Array,
//     family: Object,
//     auth: Object,
// })
const selectedCategory = ref('')
// const tasks = ref<Task[]>([])
const categories = ref<Category[]>([
    {
        id: '0',
        name: '買い物',
    },
    {
        id: '1',
        name: '買い物2',
    },
    {
        id: '1',
        name: '買い物2',
    },
    {
        id: '1',
        name: '買い物2',
    },
    {
        id: '1',
        name: '買い物2',
    },
    {
        id: '1',
        name: '買い物2',
    },
])
const settingsItems = [
    { value: 'notifications', title: 'Notifications', subtitle: 'Notify me about updates to apps or games that I downloaded' },
    { value: 'sound', title: 'Sound', subtitle: 'Auto-update apps at any time. Data charges may apply' },
    { value: 'widgets', title: 'Auto-add widgets', subtitle: 'Automatically add home screen widgets when downloads complete' },
]

const settingsSelection = ref([])
</script>

<template>
    <div class="todo-list pa-3">
        <v-chip-group
            v-model="selectedCategory"
            mandatory
            selected-class="text-primary"
            :mobile="true">
            <v-chip
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
                :color="category.color">
                {{ category.name }}
            </v-chip>
        </v-chip-group>
    </div>
    <v-list
        v-model:selected="settingsSelection"
        lines="three"
        select-strategy="leaf"
        class="px-3"
        bg-color="transparent">
        <v-list-subheader>未完了タスク</v-list-subheader>
        <v-list-item
            v-for="item in settingsItems"
            :key="item.value"
            :title="item.title"
            :value="item.value"
            min-height="auto"
            class="todo-list-item bg-surface rounded-lg pa-3 mb-3"
            active-class="line-through">
            <template #prepend="{ isSelected, select }">
                <v-list-item-action start>
                    <v-checkbox-btn
                        color="secondary"
                        :model-value="isSelected"
                        @update:model-value="select"></v-checkbox-btn>
                </v-list-item-action>
            </template>
            <template #append>
                <!--                <v- -->
                <!--                <v-avatar>-->
                <!--                    <v-icon icon="mdi-pencil-outline"></v-icon>-->
                <!--                </v-avatar>-->
            </template>
        </v-list-item>
        <v-list-subheader>完了タスク</v-list-subheader>
    </v-list>
</template>

<style lang="scss" scoped>
.todo-list-item {
    :deep(.v-list-item__prepend) {
        padding-top: 0 !important;
    }

    &.line-through {
        :deep(.v-list-item__content) {
            text-decoration: line-through;
        }
    }
}
</style>
