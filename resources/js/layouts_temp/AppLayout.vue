<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import Sidebar from '../Components/Navigation/Sidebar.vue'
import Topbar from '../Components/Navigation/Topbar.vue'

const page = usePage()
const user = computed(() => page.props.auth?.user ?? null)

const sidebarCollapsed = ref(false)

function toggleSidebar() {
    sidebarCollapsed.value = !sidebarCollapsed.value
}
</script>

<template>
    <div class="flex min-h-screen bg-[#e2ecefa6]">
        <Sidebar
            :collapsed="sidebarCollapsed"
            @toggle="toggleSidebar"
        />

        <div class="flex min-w-0 flex-1 flex-col">
            <Topbar :user="user" />

            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>