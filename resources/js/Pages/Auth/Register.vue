<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import logo from '../../../assets/images/inventiq_logo.png'
import companyCard from '../../../assets/images/company-card.png'

const page = usePage()
const isRegister = ref(false)

const loginForm = ref({
    email: '',
    password: '',
})

const registerForm = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const errorMessage = computed(() => {
    const errors = page.props.errors || {}

    return (
        errors.name ||
        errors.email ||
        errors.password ||
        errors.password_confirmation ||
        errors.message ||
        null
    )
})

function showRegister() {
    isRegister.value = true
    window.history.pushState({}, '', '/register')
}

function showLogin() {
    isRegister.value = false
    window.history.pushState({}, '', '/login')
}

function login() {
    router.post('/login', loginForm.value, {
        preserveScroll: true,
    })
}

function register() {
    router.post('/register', registerForm.value, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="min-h-screen overflow-hidden bg-white font-sans lg:grid lg:grid-cols-2">
        <!-- FORM SIDE -->
        <div
            class="relative flex min-h-screen items-center justify-center px-6 py-10 transition-all duration-700 ease-in-out"
            :class="isRegister ? 'lg:translate-x-full' : 'lg:translate-x-0'"
        >
            <div class="absolute left-6 top-6 lg:left-10 lg:top-8">
                <img
                    :src="logo"
                    alt="Inventiq Logo"
                    class="h-12 lg:h-14"
                >
            </div>

            <div class="w-full max-w-md">
                <!-- SWITCH BUTTONS -->

                <div
                    v-if="errorMessage"
                    class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                >
                    {{ errorMessage }}
                </div>

                <!-- LOGIN FORM -->
                <form
                    v-if="!isRegister"
                    @submit.prevent="login"
                    class="transition-all duration-500"
                >
                    <div class="mb-8 text-center">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">
                            Welcome back
                        </h1>

                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            Start your experience with Inventiq by logging in to your account.
                        </p>
                    </div>

                    <div class="mb-8 grid grid-cols-2 rounded-xl bg-gray-100 p-1 text-sm font-semibold">
                        <button
                            type="button"
                            class="rounded-lg py-3 transition"
                            :class="!isRegister ? 'bg-black text-white shadow' : 'text-gray-500'"
                            @click="showLogin"
                        >
                            Sign In
                        </button>

                        <button
                            type="button"
                            class="rounded-lg py-3 transition"
                            :class="isRegister ? 'bg-black text-white shadow' : 'text-gray-500'"
                            @click="showRegister"
                        >
                            Sign Up
                        </button>
                    </div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Email Address
                    </label>

                    <input
                        v-model="loginForm.email"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                        placeholder="Enter your email"
                        type="email"
                    >

                    <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                        Password
                    </label>

                    <input
                        v-model="loginForm.password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                        placeholder="Enter your password"
                        type="password"
                    >

                    <button
                        type="submit"
                        class="mt-6 w-full rounded-xl bg-black py-3.5 text-sm font-semibold text-white transition hover:bg-gray-800 active:scale-[0.99]"
                    >
                        Login
                    </button>
                </form>

                <!-- REGISTER FORM -->
                <form
                    v-else
                    @submit.prevent="register"
                    class="transition-all duration-500"
                >
                    <div class="mb-8 text-center">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">
                            Create account
                        </h1>

                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            Register to start managing your inventory smarter.
                        </p>
                    </div>
                    
                    <div class="mb-8 grid grid-cols-2 rounded-xl bg-gray-100 p-1 text-sm font-semibold">
                        <button
                            type="button"
                            class="rounded-lg py-3 transition"
                            :class="!isRegister ? 'bg-black text-white shadow' : 'text-gray-500'"
                            @click="showLogin"
                        >
                            Sign In
                        </button>

                        <button
                            type="button"
                            class="rounded-lg py-3 transition"
                            :class="isRegister ? 'bg-black text-white shadow' : 'text-gray-500'"
                            @click="showRegister"
                        >
                            Sign Up
                        </button>
                    </div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Full Name
                    </label>

                    <input
                        v-model="registerForm.name"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                        placeholder="Enter your name"
                        type="text"
                    >

                    <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                        Email Address
                    </label>

                    <input
                        v-model="registerForm.email"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                        placeholder="Enter your email"
                        type="email"
                    >

                    <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                        Password
                    </label>

                    <input
                        v-model="registerForm.password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                        placeholder="Create password"
                        type="password"
                    >

                    <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                        Confirm Password
                    </label>

                    <input
                        v-model="registerForm.password_confirmation"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                        placeholder="Confirm password"
                        type="password"
                    >

                    <button
                        type="submit"
                        class="mt-6 w-full rounded-xl bg-black py-3.5 text-sm font-semibold text-white transition hover:bg-gray-800 active:scale-[0.99]"
                    >
                        Register
                    </button>
                </form>
            </div>
        </div>

        <!-- IMAGE SIDE -->
        <div
            class="hidden min-h-screen overflow-hidden transition-all duration-700 ease-in-out lg:block"
            :class="isRegister ? 'lg:-translate-x-full' : 'lg:translate-x-0'"
        >
            <img
                :src="companyCard"
                alt="Company"
                class="h-full w-full object-cover"
            >
        </div>
    </div>
</template>