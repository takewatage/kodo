<script setup lang="ts">
import { ref } from 'vue'
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const props = defineProps<{
    auth: {};
}>();


</script>

<template>
    <Head title="Register" />

    <AuthenticatedLayout>

    </AuthenticatedLayout>
</template>
