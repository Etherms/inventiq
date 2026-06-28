<script setup>
import { Search } from 'lucide-vue-next'
import MailButton from '../Notifications/MailButton.vue'
import NotificationBell from '../Notifications/NotificationBell.vue'
import Profile from '../Dropdowns/ProfileDropdown.vue'

defineProps({
    user: {
        type: Object,
        default: null,
    },
})
</script>

<template>
    <header class="h-16 shrink-0 bg-[#EAF6FA] px-6 flex items-center justify-between">
        <div class="w-full max-w-md">
            <div class="flex h-14 items-center bg-white px-3 rounded-[20px] overflow-hidden inset-shadow-md">
                <Search class="h-4 w-4 text-gray-500" />

                <input
                    type="text"
                    placeholder="Search"
                    class="ml-2 w-full bg-transparent text-sm outline-none"
                >
            </div>
        </div>

        <div class="flex items-center gap-4">
            <MailButton />
            <NotificationBell />
            <Profile :user="user" />
        </div>
    </header>
</template>