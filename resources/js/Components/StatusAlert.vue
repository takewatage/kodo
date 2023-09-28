<script setup lang="ts">
import { ref, watch } from 'vue'

const props = defineProps<{
    status?: string
}>()

const text = ref<string>('')

watch(
    () => props.status,
    () => {
        if (!props.status) return
        switch (props.status) {
            case 'verification-link-sent':
                text.value = '新しい確認リンクがあなたのメールアドレスに送信されました。'
                break
            default:
                text.value = props.status
        }
    }
)
</script>

<template>
    <v-alert
        v-if="text"
        color="success"
    >
        {{ text }}
    </v-alert>
</template>
