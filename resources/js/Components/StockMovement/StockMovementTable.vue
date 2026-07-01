<script setup>
import StockMovementRow from './StockMovementRow.vue'
import HeaderRowFilter from '../Global/HeaderRowFilter.vue'
import TablePagination from '../Global/TablePagination.vue'

defineProps({
    movements: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: false,
    },
    pagination: {
        type: Object,
        default: () => ({}),
    },
    sortBy: {
        type: String,
        default: '',
    },
    sortDirection: {
        type: String,
        default: 'asc',
    },
})

defineEmits(['view', 'page-change', 'sort'])

const columns = [
    { key: 'created_at', label: 'Date', sortable: true },
    { key: 'product', label: 'Product', sortable: false },
    { key: 'type', label: 'Type', sortable: true },
    { key: 'quantity', label: 'Quantity', sortable: true },
    { key: 'previous_stock', label: 'Previous', sortable: true },
    { key: 'new_stock', label: 'New', sortable: true },
    { key: 'user', label: 'User', sortable: false },
    { key: 'ref_number', label: 'Reference', sortable: true },
]
</script>

<template>
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <HeaderRowFilter
                :columns="columns"
                :sort-by="sortBy"
                :sort-direction="sortDirection"
                @sort="$emit('sort', $event)"
            />

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

        <TablePagination
            :pagination="pagination"
            @page-change="$emit('page-change', $event)"
        />
    </div>
</template>