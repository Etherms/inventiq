<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import logo from '../../../assets/images/inventiq_logo.png'
import companyCard from '../../../assets/images/company-card.png'
import logoWhite from '../../../assets/images/inventiq_logo_white.png'

const page = usePage()

const isRegister = ref(page.props.mode === 'register')
const activeSide = ref(page.props.mode === 'register' ? 'register' : 'login')
const isChanging = ref(false)

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

const loginErrorMessage = computed(() => {
    const errors = page.props.errors || {}

    if (activeSide.value !== 'login' || isChanging.value) return null

    return errors.email || errors.password || errors.message || null
})

const registerErrorMessage = computed(() => {
    const errors = page.props.errors || {}

    if (activeSide.value !== 'register' || isChanging.value) return null

    return (
        errors.name ||
        errors.email ||
        errors.password ||
        errors.password_confirmation ||
        errors.message ||
        null
    )
})

function switchMode(mode) {
    if (isChanging.value) return

    isChanging.value = true
    isRegister.value = mode === 'register'

    window.history.pushState({}, '', mode === 'register' ? '/register' : '/login')

    setTimeout(() => {
        activeSide.value = mode
    }, 220)

    setTimeout(() => {
        isChanging.value = false
    }, 700)
}

function showLogin() {
    switchMode('login')
}

function showRegister() {
    switchMode('register')
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
    <div class="min-h-screen overflow-hidden bg-gray-100 p-4 font-sans sm:p-6 lg:p-8">
        <div class="relative min-h-[calc(100vh-2rem)] lg:min-h-[calc(100vh-4rem)]">
            <!-- AUTH CARD -->
            <section
                class="relative z-20 flex min-h-[calc(100vh-2rem)] items-center justify-center rounded-[2rem] border border-gray-200 bg-white px-6 py-20 shadow-2xl shadow-gray-300/60 transition-all duration-700 ease-in-out sm:px-10 lg:absolute lg:left-0 lg:top-0 lg:h-full lg:min-h-0 lg:w-[calc(50%-1rem)] lg:px-14"
                :class="isRegister
                    ? 'lg:translate-x-[calc(100%+2rem)] lg:z-0'
                    : 'lg:translate-x-0 lg:z-30'
                "
            >
                <img
                    :src="logo"
                    alt="Inventiq Logo"
                    class="absolute left-6 top-6 h-12 sm:left-8 sm:top-8 lg:h-14"
                >

                <div class="w-full max-w-md">
                    <div class="mb-8 text-center">
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-950 sm:text-4xl">
                            {{ activeSide === 'register' ? 'Create account' : 'Welcome back' }}
                        </h1>

                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            {{
                                isRegister
                                    ? 'Register to start managing your inventory smarter.'
                                    : 'Start your experience with Inventiq by logging in to your account.'
                            }}
                        </p>
                    </div>

                    <div class="mb-7 grid grid-cols-2 rounded-2xl bg-gray-100 p-1 text-sm font-semibold">
                        <button
                            type="button"
                            class="rounded-xl py-3 transition-all duration-300"
                            :class="!isRegister ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:text-gray-900'"
                            @click="showLogin"
                        >
                            Sign In
                        </button>

                        <button
                            type="button"
                            class="rounded-xl py-3 transition-all duration-300"
                            :class="isRegister ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:text-gray-900'"
                            @click="showRegister"
                        >
                            Sign Up
                        </button>
                    </div>

                    <div
                        v-if="activeSide === 'login' && loginErrorMessage"
                        class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        {{ loginErrorMessage }}
                    </div>

                    <div
                        v-if="activeSide === 'register' && registerErrorMessage"
                        class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        {{ registerErrorMessage }}
                    </div>

                    <!-- LOGIN FORM -->
                    <form
                        v-if="activeSide === 'login'"
                        @submit.prevent="login"
                    >
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Email Address
                        </label>

                        <input
                            v-model="loginForm.email"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                            placeholder="Enter your email"
                            type="email"
                        >

                        <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                            Password
                        </label>

                        <input
                            v-model="loginForm.password"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
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
                        v-if="activeSide === 'register'"
                        @submit.prevent="register"
                    >
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Full Name
                        </label>

                        <input
                            v-model="registerForm.name"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                            placeholder="Enter your name"
                            type="text"
                        >

                        <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                            Email Address
                        </label>

                        <input
                            v-model="registerForm.email"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                            placeholder="Enter your email"
                            type="email"
                        >

                        <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                            Password
                        </label>

                        <input
                            v-model="registerForm.password"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
                            placeholder="Create password"
                            type="password"
                        >

                        <label class="mb-2 mt-5 block text-sm font-semibold text-gray-700">
                            Confirm Password
                        </label>

                        <input
                            v-model="registerForm.password_confirmation"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3.5 text-sm outline-none transition focus:border-black focus:ring-2 focus:ring-black/10"
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
            </section>

            <!-- IMAGE CARD -->
            <section
                class="relative mt-6 hidden overflow-hidden rounded-[2rem] bg-gradient-to-br from-zinc-950 via-black to-zinc-900 shadow-2xl shadow-black/30 transition-all duration-700 ease-in-out lg:absolute lg:right-0 lg:top-0 lg:mt-0 lg:block lg:h-full lg:w-[calc(50%-1rem)]"
                :class="isRegister
                    ? 'lg:-translate-x-[calc(100%+2rem)] lg:z-30'
                    : 'lg:translate-x-0 lg:z-0'
                "
            >
                <!-- Decorative Background -->
                <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-24 h-[28rem] w-[28rem] rounded-full bg-white/5 blur-3xl"></div>

                <!-- Grid Pattern -->
                <div
                    class="absolute inset-0 opacity-5"
                    style="
                        background-image:
                            linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px),
                            linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px);
                        background-size:40px 40px;
                    "
                ></div>

                <div class="relative flex h-full flex-col justify-between p-12 text-white">
                    <!-- Logo -->
                    <div>
                        <img
                            :src="logoWhite"
                            alt="Inventiq"
                            class="h-30"
                        >
                    </div>

                    <!-- Main Content -->
                    <div class="max-w-lg">
                        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.3em] text-white/60">
                            INVENTORY MANAGEMENT
                        </p>

                        <h2 class="text-5xl font-black leading-tight tracking-tight">
                            Smarter inventory.
                            <br>
                            Faster decisions.
                        </h2>

                        <p class="mt-6 text-lg leading-8 text-white/70">
                            Manage products, suppliers, stock movement, and inventory
                            insights from one modern dashboard designed for growing
                            businesses.
                        </p>
                    </div>

                    <!-- Bottom Feature Cards -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-bold">24/7</p>
                            <p class="mt-2 text-sm text-white/60">
                                Access
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-bold">100%</p>
                            <p class="mt-2 text-sm text-white/60">
                                Organized
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-bold">∞</p>
                            <p class="mt-2 text-sm text-white/60">
                                Scalable
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>