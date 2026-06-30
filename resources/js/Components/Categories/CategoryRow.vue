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
            <div class="flex justify-end gap-3">
                <button
                    @click="$emit('edit', category)"
                    class="text-sm text-blue-600 hover:underline">
                    Edit
                </button>
                                <button
                        type="button"
                        @click="$emit('delete', category)"
                        class="text-sm text-red-600 hover:underline"
                    >
                    Delete
                </button>
            </div>
        </td>
    </tr>
</template>