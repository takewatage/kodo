<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
// import Post from '@/models/Post'
import { router } from '@inertiajs/vue3'
import { useDialogService } from '@/composables/common/useDialogService'
import { useConfirmDialog } from '@/composables/common/useConfirmDialogService'
import DiscountDialog from '@/components/Dok/DiscountDialog.vue'
import { useOverlayService } from '@/composables/common/useOverlayService'
import SamePriceImg from '@/components/Dok/SamePriceImg.vue'

// const props = defineProps<{
//     posts: PaginationModel<Post>
// }>()

defineOptions({ layout: AuthenticatedLayout })
const dialog = useDialogService()
const overlay = useOverlayService()
const { confirm } = useConfirmDialog()

const handle = async () => {
    console.log('handle')
    const confirmed = await confirm({
        title: 'Delete Item',
        message: 'This action cannot be undone. Are you sure?',
        confirmText: 'Delete',
        confirmColor: 'error',
    })

    if (confirmed) {
        console.log('Item deleted')
    }
}

const custom = async () => {
    dialog.open({
        component: DiscountDialog,
        props: {
            title: '確認',
            message: '処理が完了しました',
        },
    })
}

const onOverlay = () => {
    overlay.open({
        component: SamePriceImg,
    })
}
</script>

<template>
    <v-container>
        <button @click="router.get('dok')">dok</button>

        <v-btn @click="handle">confirm dialog</v-btn>

        <v-btn @click="custom">custom dialog</v-btn>

        <v-btn @click="onOverlay">overlay</v-btn>
    </v-container>
</template>
