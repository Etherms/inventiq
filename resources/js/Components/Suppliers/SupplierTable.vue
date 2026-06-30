<script setup>
import SupplierRow from './SupplierRow.vue'

defineProps({
    suppliers: {
        type: Array,
        default: () => []
    },
    loading: {
        type: Boolean,
        default: false
    }
})
</script>


<template>
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Contact Person</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading">
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        Loading Suppliers...
                    </td>
                </tr>

                <tr v-else-if="suppliers.length === 0">
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        No suppliers found.
                    </td>
                </tr>

                <SupplierRow
                    v-for="supplier in suppliers"
                    :key="supplier.id"
                    :supplier="supplier"
                    @edit="$emit('edit', $event)"
                    @delete="$emit('delete', $event)"
                />
            </tbody>
        </table>
    </div>
</template>