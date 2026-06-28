<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import CategoryModal from './CategoryModal.vue'

const props = defineProps({
    show: Boolean,
    category: {
        type: Object,
        default: null,
    },
})

const emit = defineEmits(['close', 'updated'])

const form = ref({
    name: '',
    description: '',
})

const loading = ref(false)
const error = ref('')

watch(
    () => props.category,
    (category) => {
        if (category) {
            form.value = {
                name: category.name || '',
                description: category.description || '',
            }
        }
    },
    { immediate: true }
)

async function submit() {
    if (!props.category) return

    loading.value = true
    error.value = ''

    try {
        const res = await axios.put(`/categories/${props.category.id}`, form.value)

        emit('updated', res.data.data)
        emit('close')
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to update category.'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <CategoryModal
        :show="show"
        title="Edit Category"
        @close="emit('close')"
    >
        <form @submit.prevent="submit" class="space-y-4">
            <p v-if="error" class="text-sm text-red-600">
                {{ error }}
            </p>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Name
                </label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                    required
                >
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Description
                </label>
                <textarea
                    v-model="form.description"
                    class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                    rows="3"
                ></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button
                    type="button"
                    @click="emit('close')"
                    class="rounded-lg border px-4 py-2 text-sm"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm text-white"
                    :disabled="loading"
                >
                    {{ loading ? 'Saving...' : 'Update' }}
                </button>
            </div>
        </form>
    </CategoryModal>
</template>