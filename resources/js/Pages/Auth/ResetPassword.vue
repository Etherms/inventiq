<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    token: String,
    email: String,
})

const form = useForm({
    token: props.token,
    email: props.email || '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post('/reset-password')
}
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
        <form
            @submit.prevent="submit"
            class="w-full max-w-md rounded-xl bg-white p-8 shadow"
        >
            <h1 class="mb-6 text-2xl font-bold">Reset Password</h1>

            <div class="space-y-4">
                <input
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    class="w-full rounded-lg border px-3 py-2"
                />

                <input
                    v-model="form.password"
                    type="password"
                    placeholder="New password"
                    class="w-full rounded-lg border px-3 py-2"
                />

                <input
                    v-model="form.password_confirmation"
                    type="password"
                    placeholder="Confirm new password"
                    class="w-full rounded-lg border px-3 py-2"
                />

                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-4 py-2 font-medium text-white"
                >
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</template>