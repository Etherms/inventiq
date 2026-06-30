<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import SupplierModal from './SupplierModal.vue'

const props = defineProps({
    show: Boolean,
    supplier: {
        type: Object,
        default: null,
    },
})

const emit = defineEmits(['close', 'updated'])

const form = ref({
    name: '',
    contact_person: '',
    email: '',
    phone: '',
    address: '',
})

const loading = ref(false)
const error = ref('')

watch(
    () => props.supplier,
    (supplier) => {
        if (supplier) {
            form.value = {
                name: supplier.name || '',
                contact_person: supplier.contact_person || '',
                email: supplier.email || '',
                phone: supplier.phone || '',
                address: supplier.address || '',
            }
        }
    },
    { immediate: true }
)

async function submit() {
    if (!props.supplier) return

    loading.value = true
    error.value = ''

    try {
        const res = await axios.put(`/api/suppliers/${props.supplier.id}`, form.value)
        emit('updated', res.data.data)
        emit('close')
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to update supplier.'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <SupplierModal
        :show="show"
        title="Edit Supplier"
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
                    Contact Person
                </label>
                <input
                    v-model="form.contact_person"
                    type="text"
                    class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                    required
                >
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    v-model="form.email"
                    type="email"
                    class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                    required
                >
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Phone
                </label>
                <input
                    v-model="form.phone"
                    type="text"
                    class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                    required
                >
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Address
                </label>
                <input
                    v-model="form.address"
                    type="text"
                    class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                    required
                >
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
    </SupplierModal>
</template>