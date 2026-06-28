<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const loading = ref(false)

function register() {
    loading.value = true

    router.post('/register', form.value, {
        onFinish: () => {
            loading.value = false
        },
    })
}
</script>
<template>
    <div v-if="checkingAuth" class="min-h-screen bg-gray-100"></div>
    <div v-else class="min-h-screen flex items-center justify-center bg-gray-100">
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