<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    item: {
        type: Object,
        required: true,
    },
    collapsed: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <Link
        :href="item.href"
        class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100"
        :class="collapsed ? 'justify-center' : ''"
        :title="collapsed ? item.label : ''"
    >
        <component :is="item.icon" class="h-5 w-5 shrink-0" />

        <span v-if="!collapsed" class="ml-3">
            {{ item.label }}
        </span>
    </Link>
</template>