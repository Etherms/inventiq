<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    movement: {
        type: Object,
        default: null,
    },
})

const emit = defineEmits(['close'])

function formatDate(date) {
    if (!date) return '—'
    return new Date(date).toLocaleString()
}
</script>

<template>
    <div
        v-if="show && movement"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >
        <div class="w-full max-w-lg rounded-xl bg-white shadow-lg">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    Stock Movement Details
                </h2>

                <button
                    type="button"
                    @click="emit('close')"
                    class="text-gray-500 hover:text-gray-900"
                >
                    ✕
                </button>
            </div>

            <div class="space-y-4 p-6">
                <div>
                    <p class="text-xs text-gray-500">Product</p>
                    <p class="font-medium text-gray-900">
                        {{ movement.product?.name || 'Unknown product' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Movement Type</p>
                        <p class="font-medium">
                            {{ movement.type === 'in' ? 'Stock In' : 'Stock Out' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Quantity</p>
                        <p class="font-medium">
                            {{ movement.type === 'in' ? '+' : '-' }}{{ movement.quantity }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Previous Stock</p>
                        <p class="font-medium">{{ movement.previous_stock }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">New Stock</p>
                        <p class="font-medium">{{ movement.new_stock }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">User</p>
                        <p class="font-medium">
                            {{ movement.user?.name || 'System' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Reference</p>
                        <p class="font-medium">
                            {{ movement.ref_number || '—' }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Notes</p>
                    <p class="text-gray-700">
                        {{ movement.notes || 'No notes provided.' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Date Created</p>
                    <p class="text-gray-700">
                        {{ formatDate(movement.created_at) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>