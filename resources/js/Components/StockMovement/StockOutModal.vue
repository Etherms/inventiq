<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import ProductModal from '../Products/ProductModal.vue'

const props = defineProps({
    show: Boolean,
    product: {
        type: Object,
        default: null,
    },
})

const emit = defineEmits(['close', 'saved'])

const form = ref({
    quantity: '',
    ref_number: '',
    notes: '',
})

const loading = ref(false)
const error = ref('')

watch(
    () => props.product,
    () => {
        form.value = {
            quantity: '',
            ref_number: '',
            notes: '',
        }
        error.value = ''
    }
)

async function submit() {
    if (!props.product) return

    loading.value = true
    error.value = ''

    try {
        await axios.post('/stock-out', {
            product_id: props.product.id,
            ...form.value,
        })

        emit('saved')
        emit('close')
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to deduct stock.'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <ProductModal :show="show" title="Stock Out" @close="emit('close')">
        <form @submit.prevent="submit" class="space-y-4">
            <p class="text-sm text-gray-600">
                Product: <strong>{{ product?.name }}</strong>
            </p>

            <p class="text-sm text-gray-500">
                Current stock: {{ product?.stock }}
            </p>

            <p v-if="error" class="text-sm text-red-600">{{ error }}</p>

            <input
                v-model="form.quantity"
                type="number"
                min="1"
                placeholder="Quantity to deduct"
                class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
                required
            >

            <input
                v-model="form.ref_number"
                type="text"
                placeholder="Reference number optional"
                class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
            >

            <textarea
                v-model="form.notes"
                rows="3"
                placeholder="Notes optional"
                class="w-full rounded-lg border px-3 py-2 text-sm outline-none"
            />

            <div class="flex justify-end gap-3">
                <button type="button" @click="emit('close')" class="rounded-lg border px-4 py-2 text-sm">
                    Cancel
                </button>

                <button type="submit" :disabled="loading" class="rounded-lg bg-orange-600 px-4 py-2 text-sm text-white">
                    {{ loading ? 'Saving...' : 'Deduct Stock' }}
                </button>
            </div>
        </form>
    </ProductModal>
</template>