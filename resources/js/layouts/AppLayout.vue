<script setup>
import { ref } from 'vue'
import Sidebar from '../Components/Layout/Sidebar.vue'
import Topbar from '../Components/Layout/Topbar.vue'

const sidebarCollapsed = ref(false)

function toggleSidebar() {
    sidebarCollapsed.value = !sidebarCollapsed.value
}
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <Sidebar
            :collapsed="sidebarCollapsed"
            @toggle="toggleSidebar"
        />

        <div class="flex min-w-0 flex-1 flex-col">
            <Topbar />

            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>