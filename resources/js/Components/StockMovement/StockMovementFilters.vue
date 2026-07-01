<script setup>
import { VueDatePicker } from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const filters = defineModel('filters', {
    type: Object,
    required: true,
})

defineEmits(['reset'])
</script>

<template>
    <div class="rounded-xl bg-white p-5 shadow-sm">
        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <input
                    v-model="filters.search"
                    type="search"
                    placeholder="Search product, SKU, or reference no."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                />
            </div>

            <div>
                <VueDatePicker
                    v-model="filters.date_range"
                    range
                    partial-range
                    :enable-time-picker="false"
                    placeholder="Select date or date range"
                    format="yyyy-MM-dd"
                    model-type="yyyy-MM-dd"
                />
            </div>
            <div>
                <button
                    type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    @click="$emit('reset')"
                >
                    Reset Filters
                </button>
            </div>
        </div>

    </div>
</template>