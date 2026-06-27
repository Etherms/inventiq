<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios'

onMounted(() =>{
    const token = localStorage.getItem('token')

    if (token) {
        window.location.href = '/dashboard'
    }
})

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const error = ref('')
const loading = ref(false)

async function register () {
    error.value = ''
    loading.value = true

    try {
        const res = await axios.post('/api/register', form.value)

        localStorage.setItem('token', res.data.token)
        window.location.href = '/dashboard'
    } catch (e) {
        error.value = e.response?.data?.message || 'Registration failed'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <form @submit.prevent="register" class="bg-white p-8 rounded shadow w-full max-w-md">

            <h1 class="text-2xl font-bold mb-6">Register</h1>

            <p v-if="error" class="mb-4 text-red-600">{{ error }}</p>

            <input v-model="form.name" class="input" placeholder="Name" type="text">
            <input v-model="form.email" class="input" placeholder="Email" type="email">
            <input v-model="form.password" class="input" placeholder="Password" type="password">
            <input v-model="form.password_confirmation" class="input" placeholder="Confirm Password" type="password">

            <button class="w-full bg-black text-white py-2 rounded mt-4">
                {{ loading ? 'Creating account..' : 'Register' }}
            </button>

            <a href="/login" class="block text-center mt-4 text-sm underline">Already have an account</a>
        </form>
    </div>
</template>