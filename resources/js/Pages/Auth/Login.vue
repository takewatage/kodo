<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from "vue";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const visible = ref(false)
const appName = import.meta.env.VITE_APP_NAME

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <div class="w-100 h-100 d-flex align-center justify-center flex-column">

            <h1 class="text-center mb-5"> {{ appName }} ADMIN </h1>

            <v-card
                class="w-100 mx-auto pa-12 pb-8"
                elevation="8"
                max-width="448"
                rounded="lg"
            >
                <form @submit.prevent="submit">

                    <InputError class="mt-2 mb-4" :message="form.errors.email" />

                    <v-text-field
                        v-model="form.email"
                        label="Account"
                        :error="form.errors.email"
                        density="compact"
                        placeholder="Email address"
                        prepend-inner-icon="mdi-email-outline"
                        variant="outlined"
                    ></v-text-field>

                    <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                        <Link
                            class="text-caption text-decoration-none text-blue ml-auto"
                            v-if="canResetPassword"
                            :href="route('password.request')"
                        >
                            Forgot login password?
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
                        :error="form.errors.email"
                        @click:append-inner="visible = !visible"
                    ></v-text-field>
                    <v-btn
                        type="submit"
                        block
                        class="mb-8"
                        color="blue"
                        size="large"
                        variant="tonal"
                        :disabled="form.processing"
                        :loading="form.processing"
                    >
                        ログイン
                    </v-btn>

                    <v-card-text class="text-center">
                        <Link
                            class="text-blue text-decoration-none"
                            :href="route('register')"
                            rel="noopener noreferrer"
                            target="_blank"
                        >
                            登録はこちら <v-icon icon="mdi-chevron-right"></v-icon>
                        </Link>
                    </v-card-text>
                </form>
            </v-card>
        </div>
    </GuestLayout>
</template>
