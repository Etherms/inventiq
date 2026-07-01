<script setup>
import StockMovementRow from './StockMovementRow.vue'

defineProps({
    movements: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: false,
    },
})

defineEmits(['view'])
</script>

<template>
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Quantity</th>
                    <th class="px-4 py-3">Previous</th>
                    <th class="px-4 py-3">New</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Reference</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="loading">
                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                        Loading stock movements...
                    </td>
                </tr>

                <tr v-else-if="movements.length === 0">
                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                        No stock movements found.
                    </td>
                </tr>

                <StockMovementRow
                    v-for="movement in movements"
                    :key="movement.id"
                    :movement="movement"
                    @click="$emit('view', movement)"
                />
            </tbody>
        </table>
    </div>
</template>