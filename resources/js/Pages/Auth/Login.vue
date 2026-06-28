<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
    email: '',
    password: '',
})

const loading = ref(false)

function login() {
    loading.value = true

    router.post('/login', form.value, {
        onFinish: () => {
            loading.value = false
        },
    })
}
</script>

<template>
    <div v-if="checkingAuth" class="min-h-screen bg-gray-100"></div>

    <div v-else class="min-h-screen flex items-center justify-center bg-gray-100">
        <form @submit.prevent="login" class="bg-white p-8 rounded shadow w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6">Login</h1>

            <p v-if="error" class="mb-4 text-red-600">{{ error }}</p>

            <input v-model="form.email" class="input" placeholder="Email" type="email">
            <input v-model="form.password" class="input" placeholder="Password" type="password">

            <button type="submit" class="w-full bg-black text-white py-2 rounded mt-4">
                {{ loading ? 'Logging in..' : 'Login' }}
            </button>

            <a href="/register" class="block text-center mt-4 text-sm underline">Create an account</a>
        </form>
    </div>
</template>