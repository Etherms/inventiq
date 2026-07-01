<script setup>
defineProps({
    movement: {
        type: Object,
        required: true,
    },
})

defineEmits(['click'])

function formatDate(date) {
    return new Date(date).toLocaleString()
}
</script>

<template>
    <tr
        @click="$emit('click')"
        class="cursor-pointer border-b hover:bg-gray-50"
    >
        <td class="px-4 py-3 text-gray-600">
            {{ formatDate(movement.created_at) }}
        </td>

        <td class="px-4 py-3 font-medium text-gray-900">
            {{ movement.product?.name || 'Unknown product' }}
        </td>

        <td class="px-4 py-3">
            <span
                class="rounded-full px-3 py-1 text-xs font-medium"
                :class="movement.type === 'in'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-orange-100 text-orange-700'"
            >
                {{ movement.type === 'in' ? 'Stock In' : 'Stock Out' }}
            </span>
        </td>

        <td
            class="px-4 py-3 font-medium"
            :class="movement.type === 'in' ? 'text-green-600' : 'text-orange-600'"
        >
            {{ movement.type === 'in' ? '+' : '-' }}{{ movement.quantity }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ movement.previous_stock }}
        </td>

        <td class="px-4 py-3 text-gray-900">
            {{ movement.new_stock }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ movement.user?.name || 'System' }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ movement.ref_number || '—' }}
        </td>
    </tr>
</template>