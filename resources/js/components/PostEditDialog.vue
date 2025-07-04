<script setup lang="ts">
import AppEditor from '@/components/AppEditor.vue'
import { useForm } from '@inertiajs/vue3'

defineProps<{
    active: boolean
}>()
defineEmits<{
    'update:active': [val: boolean]
}>()

const form = useForm({
    content: '',
    title: '',
})
</script>

<template>
    <v-dialog
        :model-value="active"
        :scrim="false"
        :fullscreen="true"
        transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar
                height="64"
                dark
                color="primary">
                <v-btn
                    icon
                    dark
                    @click="$emit('update:active', false)">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title>今日のKoDoを投稿しよう</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn
                        variant="text"
                        @click="$emit('update:active', false)">
                        投稿
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-container class="pt-5">
                <v-text-field
                    v-model="form.title"
                    label="タイトル"
                    class="label-bold"
                    :error="form.errors.hasOwnProperty('title')"
                    density="compact"
                    variant="outlined" />

                <AppEditor
                    v-model="form.content"
                    label="本文" />
            </v-container>
        </v-card>
    </v-dialog>
</template>
