<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue'
import InputError from '@/components/InputError.vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthCard from '@/components/Auth/AuthCard.vue'

defineProps<{
    canResetPassword?: boolean
    status?: string
}>()

defineOptions({ layout: GuestLayout })

const visible = ref(false)
const page = usePage()

const appName: string = page.props.appName
const form = useForm({
    email: '',
    password: '',
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password')
        },
    })
}
</script>

<template>
    <Head title="Login" />

    <AuthCard :title="appName">
        <form @submit.prevent="submit">
            <InputError
                class="mt-2 mb-4"
                :message="form.errors.email" />

            <v-text-field
                v-model="form.email"
                label="Account"
                :error="form.errors.hasOwnProperty('email')"
                density="compact"
                placeholder="Email address"
                prepend-inner-icon="mdi-email-outline"
                variant="outlined"></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                <Link
                    v-if="canResetPassword"
                    class="text-caption text-primary ml-auto"
                    :href="route('password.request')">
                    パスワードを忘れた場合はこちら
                </Link>
            </div>

            <v-text-field
                v-model="form.password"
                :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                :type="visible ? 'text' : 'password'"
                density="compact"
                placeholder="Enter your password"
                prepend-inner-icon="mdi-lock-outline"
                variant="outlined"
                label="Password"
                :error="form.errors.hasOwnProperty('email')"
                @click:append-inner="visible = !visible"></v-text-field>
            <v-btn
                type="submit"
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                :disabled="form.processing"
                :loading="form.processing">
                ログイン
            </v-btn>

            <v-card-text class="text-center">
                <Link
                    class="text-primary"
                    :href="route('register')">
                    アカウントをお持ちでない場合は登録
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </Link>
            </v-card-text>
        </form>
    </AuthCard>
</template>

<style scoped lang="scss">
@use '/resources/sass/variables.module';
.test {
    font-size: variables.$font-small;
}
</style>
