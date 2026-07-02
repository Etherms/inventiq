<script setup>
import HeaderRowFilter from '../Global/HeaderRowFilter.vue'
import TablePagination from '../Global/TablePagination.vue'
import { Pencil, Trash2 } from 'lucide-vue-next'

defineProps({
    categories: {
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

defineEmits(['edit', 'delete', 'sort', 'page-change'])

const columns = [
    { key: 'name', label: 'Name', sortable: true },
    { key: 'description', label: 'Description', sortable: true },
    { key: 'created_at', label: 'Date Created', sortable: true },
    { key: 'actions', label: 'Actions', class: 'text-right', align: 'right' },
]
</script>

<template>
    <div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <HeaderRowFilter
                    :columns="columns"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
                    @sort="$emit('sort', $event)"
                />

                <tbody class="divide-y divide-gray-100 h-119.75" v-if="loading">
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Loading categories...
                        </td>
                    </tr>
                </tbody>
                <tbody v-else-if="categories.length === 0">
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            No categories found.
                        </td>s
                    </tr>
                    </tbody>
                <tbody v-else>
                    <tr
                        v-for="category in categories"
                        :key="category.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ category.name }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ category.description || 'No description' }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ new Date(category.created_at).toLocaleDateString() }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <button
                                    type="button"
                                    @click="$emit('edit', category)"
                                    class="rounded-lg border p-2 text-gray-600 hover:bg-gray-100"
                                >
                                    <Pencil class="h-4 w-4" />
                                </button>

                                <button
                                    type="button"
                                    @click="$emit('delete', category)"
                                    class="rounded-lg border p-2 text-red-600 hover:bg-red-50"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <TablePagination
            :pagination="pagination"
            @page-change="$emit('page-change', $event)"
        />
    </div>
</template>