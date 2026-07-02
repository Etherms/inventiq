<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>

<template>
    <AppLayout>
        <h1 class="text-3xl font-bold mb-4">Dashboard</h1>

        <div class="bg-white p-6 rounded-md shadow">
            <p class="text-lg">
                Welcome, {{ user?.name }}
            </p>
        </div>
    </AppLayout>
</template>