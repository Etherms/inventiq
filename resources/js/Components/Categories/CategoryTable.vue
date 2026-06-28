<script setup>
import CategoryRow from './CategoryRow.vue'

defineProps({
    categories: {
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
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="loading">
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        Loading categories...
                    </td>
                </tr>

                <tr v-else-if="categories.length === 0">
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        No categories found.
                    </td>
                </tr>

                <CategoryRow
                    v-for="category in categories"
                    :key="category.id"
                    :category="category"
                    @edit="$emit('edit', $event)"
                />
            </tbody>
        </table>
    </div>
</template>