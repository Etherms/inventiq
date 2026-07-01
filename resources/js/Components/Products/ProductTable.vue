<script setup>
import ProductRow from './ProductRow.vue'
import HeaderRowFilter from '../Global/HeaderRowFilter.vue'
import TablePagination from '../Global/TablePagination.vue'
defineProps({
    products: {
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

defineEmits([
    'edit',
    'delete',
    'stock-in',
    'stock-out',
    'page-change',
    'sort',
])

const columns = [
    { key: 'checkbox', label: '', class: 'w-12' },
    { key: 'name', label: 'Product', sortable: true },
    { key: 'selling_price', label: 'Price', sortable: true },
    { key: 'stock', label: 'Qty', sortable: true },
    { key: 'supplier_id', label: 'Store', sortable: true },
    { key: 'status', label: 'Availability', sortable: true },
    { key: 'actions', label: 'Action', align: 'right', class: 'text-right' },
]
</script>

<template>
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm text-black outline-1">
            <HeaderRowFilter
                :columns="columns"
                :sort-by="sortBy"
                :sort-direction="sortDirection"
                @sort="$emit('sort', $event)"
            />

            <tbody class="divide-y divide-gray-700">
                <tr v-if="loading">
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                        Loading Products...
                    </td>
                </tr>

                <tr v-else-if="products.length === 0">
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                        No products found.
                    </td>
                </tr>

                <ProductRow
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                    @stock-in="$emit('stock-in', $event)"
                    @stock-out="$emit('stock-out', $event)"
                    @edit="$emit('edit', $event)"
                    @delete="$emit('delete', $event)"
                />
            </tbody>
        </table>
        <TablePagination
            :pagination="pagination"
            @page-change="$emit('page-change', $event)"/>
    </div>
</template>