<script setup>
import { Plus, Minus, Pencil, Trash2 } from 'lucide-vue-next'

defineProps({
    product: {
        type: Object,
        required: true,
    },
})

defineEmits(['stock-in', 'stock-out','edit', 'delete'])
</script>

<template>
    <tr class="bg-[#ffffff] hover:bg-[#bfbfbf]">
        <td class="px-4 py-3">
            <input type="checkbox" class="rounded border-gray-500 bg-transparent">
        </td>

        <td class="px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white text-xs font-bold text-gray-900">
                    {{ product.name?.charAt(0) }}
                </div>

                <div>
                    <p class="max-w-45 truncate font-medium text-black">
                        {{ product.name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ product.sku }}
                    </p>
                </div>
            </div>
        </td>

        <td class="px-4 py-3 text-black">
            ₱{{ product.selling_price }}
        </td>

        <td class="px-4 py-3 text-black">
            {{ product.stock }}
        </td>

        <td class="px-4 py-3 text-black">
            {{ product.supplier?.name || 'No supplier' }}
        </td>

        <td class="px-4 py-3 text-black">
            <span
                class="rounded-full px-3 py-1 text-xs font-medium"
                :class="product.status
                    ? 'border border-emerald-500 text-emerald-400'
                    : 'border border-pink-500 text-pink-400'"
            >
                {{ product.status ? 'Active' : 'Inactive' }}
            </span>
        </td>

            <td class="px-4 py-3 text-right">
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    @click="$emit('stock-in', product)"
                    class="inline-flex items-center gap-1 rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-200"
                >
                    <Plus class="h-3.5 w-3.5" />
                    In
                </button>

                <button
                    type="button"
                    @click="$emit('stock-out', product)"
                    class="inline-flex items-center gap-1 rounded-lg bg-orange-100 px-3 py-1.5 text-xs font-medium text-orange-700 hover:bg-orange-200"
                >
                    <Minus class="h-3.5 w-3.5" />
                    Out
                </button>

                <button
                    type="button"
                    @click="$emit('edit', product)"
                    class="rounded-lg px-2 py-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-900"
                >
                    <Pencil class="h-4 w-4" />
                </button>

                <button
                    type="button"
                    @click="$emit('delete', product)"
                    class="rounded-lg px-2 py-1.5 text-gray-500 hover:bg-red-50 hover:text-red-600"
                >
                    <Trash2 class="h-4 w-4" />
                </button>
            </div>
        </td>
    </tr>
</template>