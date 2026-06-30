<script setup>
defineProps({
    show: Boolean,
    title: {
        type: String,
        default: 'Supplier',
    },
})

const emit = defineEmits(['close'])
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >
        <div class="w-full max-w-md rounded-xl bg-white shadow-lg">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ title }}
                </h2>

                <button
                    type="button"
                    @click="emit('close')"
                    class="text-gray-500 hover:text-gray-900"
                >
                    ✕
                </button>
            </div>

            <div class="p-6">
                <slot />
            </div>
        </div>
    </div>
</template>