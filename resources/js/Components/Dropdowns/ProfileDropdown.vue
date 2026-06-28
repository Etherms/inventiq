<script setup>
import { computed, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { User, Settings, Palette, LogOut, ChevronDown } from 'lucide-vue-next'

const props = defineProps({
    user: {
        type: Object,
        default: () => ({
            name: 'Inventiq User',
            email: '',
        }),
    },
})

const open = ref(false)

const initials = computed(() => {
    return props.user?.name
        ?.split(' ')
        .map(word => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase() || 'IU'
})

function logout() {
    localStorage.removeItem('token')
    window.location.href = '/login'
}
</script>

<template>
    <div class="relative">
        <button
            type="button"
            @click="open = !open"
            class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-gray-100"
        >
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                {{ initials }}
            </div>

            <ChevronDown class="h-4 w-4 text-gray-500" />
        </button>

        <div
            v-if="open"
            class="absolute right-0 z-50 mt-2 w-56 rounded-lg border bg-white py-2 shadow-lg"
        >
            <div class="border-b px-4 py-3">
                <p class="text-sm font-semibold text-gray-900">
                    {{ user.name }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ user.email }}
                </p>
            </div>

            <Link href="/profile" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <User class="h-4 w-4" />
                Profile
            </Link>

            <Link href="/settings" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <Settings class="h-4 w-4" />
                Settings
            </Link>

            <Link href="/theme" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <Palette class="h-4 w-4" />
                Theme
            </Link>

            <button
                type="button"
                @click="logout"
                class="flex w-full items-center gap-3 px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
            >
                <LogOut class="h-4 w-4" />
                Logout
            </button>
        </div>
    </div>
</template>