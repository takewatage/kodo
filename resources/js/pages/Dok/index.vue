<script setup lang="ts">
import DokLayout from '@/layouts/DokLayout.vue'
import { computed } from 'vue'
import { useLayout } from 'vuetify'
import { useTab } from '@/composables/dok/useTab'
import Dok from '@/pages/Dok/dok.vue'
import TodoList from '@/components/Todo/TodoList.vue'

defineOptions({ layout: DokLayout })

const { getLayoutItem } = useLayout()
const tabHeight = computed((): number => {
    const appBarSize = getLayoutItem('app-bar')?.size || 0
    return window.innerHeight - appBarSize
})
const { tab } = useTab()
</script>

<template>
    <div>
        <v-tabs-window v-model="tab">
            <v-tabs-window-item
                class="main-content"
                value="dok"
                :style="{ height: tabHeight + 'px' }">
                <Dok />
            </v-tabs-window-item>
            <v-tabs-window-item
                value="todo"
                :style="{ height: tabHeight + 'px' }">
                <TodoList />
            </v-tabs-window-item>
        </v-tabs-window>
    </div>
</template>

<style lang="scss" scoped>
.main-content {
    transition: height 0.2s ease-in;
    position: relative;
}
</style>
