<script setup>
import { Pencil, Trash2 } from 'lucide-vue-next'

defineProps({
    product: {
        type: Object,
        required: true,
    },
})

defineEmits(['edit', 'delete'])
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
            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    @click="$emit('edit', product)"
                    class="text-black hover:text-grey-400"
                >
                    <Pencil class="h-4 w-4" />
                </button>

                <button
                    type="button"
                    @click="$emit('delete', product)"
                    class="text-black hover:text-grey-400"
                >
                    <Trash2 class="h-4 w-4" />
                </button>
            </div>
        </td>
    </tr>
</template>