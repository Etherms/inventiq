<script setup>
const emit = defineEmits(['export', 'import'])

function handleImport(event) {
    const file = event.target.files[0]

    emit('import', file)

    event.target.value = ''
}
</script>

<template>
    <div class="flex flex-wrap gap-2">
        <button
            type="button"
            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
            @click="$emit('export')"
        >
            Export CSV
        </button>

        <label
            class="cursor-pointer rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
        >
            Import CSV
            <input
                type="file"
                accept=".csv"
                class="hidden"
                @change="handleImport"
            />
        </label>
    </div>
</template>