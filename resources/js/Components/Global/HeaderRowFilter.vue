<script setup>
import { ArrowUpDown, ArrowUp, ArrowDown } from 'lucide-vue-next'

defineProps({
    columns: {
        type: Array,
        required: true,
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

defineEmits(['sort'])
</script>

<template>
    <thead class="bg-white text-xs uppercase text-black border-b-2">
        <tr>
            <th
                v-for="column in columns"
                :key="column.key"
                :class="[
                    'px-4 py-3',
                    column.class || '',
                    column.sortable ? 'cursor-pointer select-none hover:bg-gray-100' : ''
                ]"
                @click="column.sortable ? $emit('sort', column.key) : null"
            >
                <div
                    class="flex items-center gap-1"
                    :class="column.align === 'right' ? 'justify-end' : ''"
                >
                    <span>{{ column.label }}</span>

                    <ArrowUp
                        v-if="sortBy === column.key && sortDirection === 'asc'"
                        class="h-3 w-3"
                    />

                    <ArrowDown
                        v-else-if="sortBy === column.key && sortDirection === 'desc'"
                        class="h-3 w-3"
                    />

                    <ArrowUpDown
                        v-else-if="column.sortable"
                        class="h-3 w-3 text-gray-400"
                    />
                </div>
            </th>
        </tr>
    </thead>
</template>