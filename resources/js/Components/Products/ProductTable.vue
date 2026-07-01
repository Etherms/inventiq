<script setup>
import ProductRow from './ProductRow.vue'

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
})

defineEmits([
    'edit',
    'delete',
    'stock-in',
    'stock-out',
    'page-change',
])
</script>

    <template>
        <div class="overflow-hidden rounded-xl bg-[#ffffff] shadow-sm">
            <table class="w-full text-left text-sm text-black outline-1">
                <thead class="bg-[#ffffff] text-xs uppercase text-black border-b-2">
                    <tr>
                        <th class="w-12 px-4 py-3">
                            <input type="checkbox" class="rounded border-gray-500 bg-transparent">
                        </th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Store</th>
                        <th class="px-4 py-3">Availability</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>

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
            <div
                v-if="pagination.last_page > 1"
                class="mt-4 flex items-center justify-between"
            >
                <button
                    class="rounded border px-3 py-2 disabled:opacity-50"
                    :disabled="!pagination.prev_page_url"
                    @click="$emit('page-change', pagination.current_page - 1)"
                >
                    Previous
                </button>

                <span class="text-sm text-gray-600">
                    Page {{ pagination.current_page }}
                    of {{ pagination.last_page }}
                </span>

                <button
                    class="rounded border px-3 py-2 disabled:opacity-50"
                    :disabled="!pagination.next_page_url"
                    @click="$emit('page-change', pagination.current_page + 1)"
                >
                    Next
                </button>
            </div>
        </div>
    </template>