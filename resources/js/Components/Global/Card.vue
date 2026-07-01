<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    label: String,
    value: {
        type: [String, Number],
        default: 0,
    },
    description: {
        type: String,
        default: '',
    },
    icon: {
        type: [Object, Function],
        default: null,
    },
    href: {
        type: String,
        default: null,
    },
})
</script>

<template>
    <component
        :is="href ? Link : 'div'"
        :href="href || undefined"
        class="block rounded-xl bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">{{ label }}</p>

                <p class="mt-2 text-2xl font-bold text-gray-900">
                    {{ value }}
                </p>

                <p v-if="description" class="mt-1 text-xs text-gray-500">
                    {{ description }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-700">
                <component
                    v-if="icon"
                    :is="icon"
                    class="h-5 w-5"
                />
            </div>
        </div>
    </component>
</template>