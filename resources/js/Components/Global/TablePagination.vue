<script setup>
defineProps({
    pagination: {
        type: Object,
        default: () => ({}),
    },
})

defineEmits(['page-change'])
</script>

<template>
    <div
        v-if="pagination.last_page > 1"
        class="flex items-center justify-between bg-white px-4 py-3"
    >
        <button
            type="button"
            class="rounded-lg border px-3 py-2 text-sm disabled:opacity-50"
            :disabled="!pagination.prev_page_url"
            @click="$emit('page-change', pagination.current_page - 1)"
        >
            Previous
        </button>

        <span class="text-sm text-gray-600">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
        </span>

        <button
            type="button"
            class="rounded-lg border px-3 py-2 text-sm disabled:opacity-50"
            :disabled="!pagination.next_page_url"
            @click="$emit('page-change', pagination.current_page + 1)"
        >
            Next
        </button>
    </div>
</template>