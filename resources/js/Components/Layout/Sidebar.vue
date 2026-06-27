<script setup>
import { navigation } from '../../Config/navigation'
import { Menu, LogOut } from 'lucide-vue-next'

defineProps({
    collapsed: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['toggle'])

function logout() {
    localStorage.removeItem('token')
    window.location.href = '/login'
}
</script>

<template>
    <aside
        :class="[
            'h-screen shrink-0 bg-white border-r flex flex-col transition-all duration-300',
            collapsed ? 'w-20' : 'w-64'
        ]"
    >
        <div class="h-16 border-b px-4 flex items-center justify-between">
            <div v-if="!collapsed">
                <h1 class="text-lg font-bold text-gray-900">Inventiq</h1>
                <p class="text-xs text-gray-500">Inventory System</p>
            </div>

            <button
                type="button"
                @click="emit('toggle')"
                class="rounded-lg p-2 hover:bg-gray-100"
            >
                <Menu class="h-5 w-5 text-gray-700" />
            </button>
        </div>

        <nav class="flex-1 space-y-1 px-3 py-4">
            <a
                v-for="item in navigation"
                :key="item.label"
                :href="item.href"
                class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100"
                :class="collapsed ? 'justify-center' : ''"
                :title="collapsed ? item.label : ''"
            >
                <component
                    :is="item.icon"
                    class="h-5 w-5 shrink-0"
                />

                <span v-if="!collapsed" class="ml-3">
                    {{ item.label }}
                </span>
            </a>
        </nav>

        <div class="border-t p-3">
            <button
                type="button"
                @click="logout"
                class="group flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50"
                :class="collapsed ? 'justify-center' : ''"
                :title="collapsed ? 'Logout' : ''"
            >
                <LogOut class="h-5 w-5 shrink-0" />

                <span v-if="!collapsed" class="ml-3">
                    Logout
                </span>
            </button>
        </div>
    </aside>
</template>