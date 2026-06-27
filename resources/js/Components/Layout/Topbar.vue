<script setup>
import { Search, Mail, Bell, UserCircle } from 'lucide-vue-next'
</script>

<template>
    <header class="h-16 shrink-0 border-b bg-white px-6 flex items-center justify-between">
        <div class="w-full max-w-md">
            <div class="flex h-10 items-center rounded-lg bg-gray-100 px-3">
                <Search class="h-4 w-4 text-gray-500" />

                <input
                    type="text"
                    placeholder="Search..."
                    class="ml-2 w-full bg-transparent text-sm outline-none"
                >
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="button" class="rounded-lg p-2 hover:bg-gray-100">
                <Mail class="h-5 w-5 text-gray-700" />
            </button>

            <button type="button" class="rounded-lg p-2 hover:bg-gray-100">
                <Bell class="h-5 w-5 text-gray-700" />
            </button>

            <button type="button" class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-gray-100">
                <img
                    src="https://ui-avatars.com/api/?name=Inventiq+User"
                    alt="Profile"
                    class="h-8 w-8 rounded-full"
                >

                <UserCircle class="h-5 w-5 text-gray-700" />
            </button>
        </div>
    </header>
</template>