<script setup>
defineProps({
    supplier: {
        type: Object,
        required: true,
    },
})

defineEmits(['edit', 'delete'])
</script>

<template>
    <tr class="border-b hover:bg-gray-50">
        <td class="px-4 py-3 font-medium">
            {{ supplier.name }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ supplier.contact_person || 'No contact person' }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ supplier.email || 'No email' }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ supplier.phone || 'No phone' }}
        </td>

        <td class="px-4 py-3 text-gray-600">
            {{ supplier.address || 'No address' }}
        </td>

        <td class="px-4 py-3 text-right">
            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    @click="$emit('edit', supplier)"
                    class="text-sm text-blue-600 hover:underline"
                >
                    Edit
                </button>

                <button
                    type="button"
                    @click="$emit('delete', supplier)"
                    class="text-sm text-red-600 hover:underline"
                >
                    Delete
                </button>
            </div>
        </td>
    </tr>
</template>