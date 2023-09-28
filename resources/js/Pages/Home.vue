<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import SideColumn from "@/Components/SideColumn.vue";
</script>

<template>
    <Head title="Register" />

    <AuthenticatedLayout>
        <v-container
            fluid
        >
            <v-row>
                <SideColumn
                    :width="250"
                >

                </SideColumn>

                <v-col
                    cols="12"
                    md
                >
                    <v-sheet
                        min-height="70vh"
                        rounded="lg"
                    >

                    </v-sheet>
                </v-col>

                <SideColumn />
            </v-row>
        </v-container>
    </AuthenticatedLayout>
</template>
