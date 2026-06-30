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
})

defineEmits(['edit', 'delete'])
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
                    @edit="$emit('edit', $event)"
                    @delete="$emit('delete', $event)"
                />
            </tbody>
        </table>
    </div>
</template>