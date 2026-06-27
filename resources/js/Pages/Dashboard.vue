<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios'
import AppLayout from './layouts/AppLayout.vue';

const user = ref(null)

onMounted(async () => {
    const token = localStorage.getItem('token')

    if (!token) {
        window.location.href = '/login'
        return
    }

    try{
        const res = await axios.get('/api/user', {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json',
            },
        })

        user.value = res.data.user ?? res.data
    } catch (e){
        localStorage.removeItem('token')
        window.location.href = '/login'
    }
})
</script>

<template>
    <AppLayout>
        <h1 class="text-3xl font-bold mb-4">Dashboard</h1>

        <div class="bg-white p-6 rounded-md shadow">
            <p v-if="user" class="text-lg">
                Welcome, {{ user.name }}
            </p>
            <p v-else>
                Loading user...
            </p>
        </div>
    </AppLayout>
</template>