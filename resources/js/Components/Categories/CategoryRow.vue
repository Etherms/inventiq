<script setup>
import { ref } from 'vue'

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <tr class="border-b hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">
            {{ category.name }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ category.description || 'No description' }}
        </td>

        <td class="px-4 py-3 text-right">
            <button 
                @click="$emit('edit', category)"
                class="text-sm text-blue-600 hover:underline">
                Edit
            </button>
        </td>
    </tr>
</template>