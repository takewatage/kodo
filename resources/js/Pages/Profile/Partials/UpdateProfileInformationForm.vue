<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3'
import User from '@/models/User'

defineProps<{
    mustVerifyEmail?: boolean
    status?: string
}>()
const emit = defineEmits(['onSuccess'])
const user: User = new User(usePage().props.auth.user)

const form = useForm({
    name: user.name,
    email: user.email,
    introduction: user.introduction,
})

const submit = () => {
    form.patch(route('profile.update'), {
        onSuccess: () => emit('onSuccess'),
    })
}
</script>

<template>
    <div>
        <header>
            <h2>プロフィール情報</h2>

            <p class="mt-1">プロフィール情報と電子メール アドレスを更新します。</p>
        </header>

        <form class="mt-6 space-y-6">
            <div>
                <v-text-field
                    v-model="form.name"
                    label="名前"
                    :error="form.errors.hasOwnProperty('name')"
                    :error-messages="form.errors.name || []"
                    density="compact"
                    variant="outlined"
                    prepend-inner-icon="mdi-account-outline"></v-text-field>
            </div>

            <div class="mt-3">
                <v-text-field
                    v-model="form.email"
                    label="メールアドレス"
                    :error="form.errors.hasOwnProperty('email')"
                    :error-messages="form.errors.email || []"
                    density="compact"
                    variant="outlined"
                    prepend-inner-icon="mdi-email-outline"></v-text-field>
            </div>

            <div class="mt-3">
                <v-textarea
                    v-model="form.introduction"
                    label="詳細"
                    :error="form.errors.hasOwnProperty('introduction')"
                    density="compact"
                    variant="outlined"></v-textarea>
            </div>

            <div v-if="mustVerifyEmail && user.emailVerifiedAt === null">
                <p class="text-sm text-gray-800 dark:text-gray-200 mb-2">
                    あなたのメールアドレスは認証されていません。
                    <Link
                        class="text-blue"
                        :href="route('verification.send')"
                        method="post"
                        as="button">
                        ここをクリックして確認メールを再送信してください。
                    </Link>
                </p>
            </div>

            <v-btn
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                :disabled="form.processing"
                :loading="form.processing"
                @click="submit">
                更新
            </v-btn>
        </form>
    </div>
</template>

<style lang="scss" scoped>
.v-text-field .v-input__details {
    margin-bottom: 10px;
}
</style>
