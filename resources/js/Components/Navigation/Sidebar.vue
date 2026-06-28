<script setup>
import { Menu, LogOut } from 'lucide-vue-next'
import { navigation } from '../../Config/navigation'
import SidebarItem from './SidebarItem.vue'

import logo from '../../../assets/images/inventiq_logo.png'

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
            'h-screen shrink-0 bg-white  flex flex-col transition-all duration-300',
            collapsed ? 'w-20' : 'w-58'
        ]"
    >
        <!-- Header -->
        <div class="h-16 px-4 flex items-center justify-center">

            <div
                v-if="!collapsed"
                class="flex items-center "
            >
                <img
                    :src="logo"
                    alt="Inventiq Logo"
                    class="h-15 w-auto flex align-items-center justify-self-center"
                />
            </div>

            <button
                type="button"
                @click="emit('toggle')"
                class="rounded-lg p-2 hover:bg-gray-100 transition"
            >
                <Menu class="h-5 w-5 text-gray-700" />
            </button>

        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 px-3 py-4">

            <SidebarItem
                v-for="item in navigation"
                :key="item.label"
                :item="item"
                :collapsed="collapsed"
            />

        </nav>
    </aside>
</template>