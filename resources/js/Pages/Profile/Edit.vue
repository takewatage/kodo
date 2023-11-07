<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'
import User from '@/models/User'
import StatusAlert from '@/Components/StatusAlert.vue'
import { ref } from 'vue'

defineProps<{
    mustVerifyEmail: boolean
    status?: string
}>()
defineOptions({ layout: AuthenticatedLayout })

const authUser = ref(new User())

const fetchAuth = () => {
    authUser.value = new User(usePage().props.auth.user)
}

fetchAuth()
</script>

<template>
    <Head title="Profile" />

    <v-container>
        <v-card class="head-card">
            <v-img
                height="200"
                src="https://cdn.vuetifyjs.com/docs/images/cards/purple-flowers.jpg"
                cover
                class="text-white"
            >
            </v-img>
        </v-card>
        <div class="v-row mt-1">
            <div class="v-col-sm-12 v-col-lg-4 v-col-12 order-sm-second">
                <div class="px-4 py-1">
                    <div class="v-row justify-center">
                        <div class="v-col v-col-4 text-center">
                            <v-icon icon="mdi-note-outline"></v-icon>
                            <h4 class="text-h4">938</h4>
                            <h6 class="text-h6 font-weight-regular">Posts</h6>
                        </div>
                        <div class="v-col v-col-4 text-center"></div>
                        <div class="v-col v-col-4 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="v-col-sm-12 v-col-lg-4 v-col-12 d-flex justify-center order-sml-first">
                <div class="text-center top-spacer">
                    <v-avatar
                        size="100"
                        color="primary"
                    >
                    </v-avatar>
                    <h5 class="text-h5 mt-3">{{ authUser.name }}</h5>
                </div>
            </div>
        </div>

        <StatusAlert :status="status" />

        <v-row class="mt-4">
            <v-col
                md="4"
                cols="12"
            >
                <v-card min-height="450">
                    <v-card-text>
                        {{ authUser.introduction }}
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                md="8"
                cols="12"
            >
                <v-card min-height="450">
                    <v-card-item>
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            @on-success="fetchAuth"
                        />
                    </v-card-item>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style lang="scss" scoped>
.top-spacer {
    margin-top: -75px;
}
</style>
