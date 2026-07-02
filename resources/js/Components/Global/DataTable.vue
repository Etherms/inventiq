<script setup>
import HeaderRowFilter from './HeaderRowFilter.vue'
import TablePagination from './TablePagination.vue'
import { Pencil, Trash2 } from 'lucide-vue-next'

defineProps({
    rows: {
        type: Array,
        default: () => [],
    },
    columns: {
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
    emptyMessage: {
        type: String,
        default: 'No records found.',
    },
    loadingMessage: {
        type: String,
        default: 'Loading...',
    },
})

defineEmits(['edit', 'delete', 'sort', 'page-change'])
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

                <tbody v-if="loading">
                    <tr>
                        <td
                            :colspan="columns.length"
                            class="px-4 py-6 text-center text-gray-500"
                        >
                            {{ loadingMessage }}
                        </td>
                    </tr>
                </tbody>

                <tbody v-else-if="rows.length === 0">
                    <tr>
                        <td
                            :colspan="columns.length"
                            class="px-4 py-6 text-center text-gray-500"
                        >
                            {{ emptyMessage }}
                        </td>
                    </tr>
                </tbody>

                <tbody v-else class="divide-y divide-gray-100">
                    <tr
                        v-for="row in rows"
                        :key="row.id"
                        class="hover:bg-gray-50"
                    >
                        <td
                            v-for="column in columns"
                            :key="column.key"
                            class="px-4 py-3"
                            :class="column.class"
                        >
                            <slot
                                :name="`cell-${column.key}`"
                                :row="row"
                                :value="row[column.key]"
                            >
                                <template v-if="column.key === 'actions'">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            @click="$emit('edit', row)"
                                            class="rounded-lg border p-2 text-gray-600 hover:bg-gray-100"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </button>

                                        <button
                                            type="button"
                                            @click="$emit('delete', row)"
                                            class="rounded-lg border p-2 text-red-600 hover:bg-red-50"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </template>

                                <template v-else-if="column.type === 'date'">
                                    {{ row[column.key] ? new Date(row[column.key]).toLocaleDateString() : '-' }}
                                </template>

                                <template v-else>
                                    {{ row[column.key] || column.fallback || '-' }}
                                </template>
                            </slot>
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