<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()

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
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <form @submit.prevent="register" class="bg-white p-8 rounded shadow w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6">Register</h1>

            <p v-if="page.props.errors.name" class="mb-2 text-sm text-red-600">
                {{ page.props.errors.name }}
            </p>

            <input v-model="form.name" class="input" placeholder="Name" type="text">

            <p v-if="page.props.errors.email" class="mb-2 mt-2 text-sm text-red-600">
                {{ page.props.errors.email }}
            </p>

            <input v-model="form.email" class="input" placeholder="Email" type="email">

            <p v-if="page.props.errors.password" class="mb-2 mt-2 text-sm text-red-600">
                {{ page.props.errors.password }}
            </p>

            <input v-model="form.password" class="input" placeholder="Password" type="password">
            <input v-model="form.password_confirmation" class="input" placeholder="Confirm Password" type="password">

            <button
                type="submit"
                class="w-full bg-black text-white py-2 rounded mt-4"
                :disabled="loading"
            >
                {{ loading ? 'Creating account..' : 'Register' }}
            </button>

            <a href="/login" class="block text-center mt-4 text-sm underline">
                Already have an account
            </a>
        </form>
    </div>
</template>