<script setup>
import { ref } from 'vue'
import Sidebar from '../Components/Navigation/Sidebar.vue'
import Topbar from '../Components/Navigation/Topbar.vue'

const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
})

const sidebarCollapsed = ref(false)

function toggleSidebar() {
    sidebarCollapsed.value = !sidebarCollapsed.value
}
</script>

<template>
    <div class="flex min-h-screen bg-[#EAF6FA]">
        <Sidebar
            :collapsed="sidebarCollapsed"
            @toggle="toggleSidebar"
        />

        <div class="flex min-w-0 flex-1 flex-col">
            <Topbar :user="props.user" />

            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>