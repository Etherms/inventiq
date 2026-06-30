    <script setup>
    import { onMounted, ref } from 'vue'
    import axios from 'axios'
    import ProductModal from './ProductModal.vue'

    defineProps({
        show: Boolean,
    })

    const emit = defineEmits(['close', 'created'])

    const categories = ref([])
    const suppliers = ref([])

    const form = ref({
        category_id: '',
        supplier_id: '',
        sku: '',
        name: '',
        description: '',
        cost_price: '',
        selling_price: '',
        stock: '',
        reorder_level: '',
        status: true,
    })

    const loading = ref(false)
    const error = ref('')

    async function fetchDropdowns() {
        const [categoryRes, supplierRes] = await Promise.all([
            axios.get('/api/categories'),
            axios.get('/api/suppliers'),
        ])

        categories.value = categoryRes.data.data
        suppliers.value = supplierRes.data.data
    }

    async function submit() {
        loading.value = true
        error.value = ''

        try {
            const res = await axios.post('/api/products', form.value)

            emit('created', res.data.data)
            emit('close')

            form.value = {
                category_id: '',
                supplier_id: '',
                sku: '',
                name: '',
                description: '',
                cost_price: '',
                selling_price: '',
                stock: '',
                reorder_level: '',
                status: true,
            }
        } catch (e) {
            error.value = e.response?.data?.message || 'Failed to create product.'
        } finally {
            loading.value = false
        }
    }

    onMounted(fetchDropdowns)
    </script>

    <template>
        <ProductModal
            :show="show"
            title="Create Product"
            @close="emit('close')"
        >
            <form @submit.prevent="submit" class="space-y-4">
                <p v-if="error" class="text-sm text-red-600">
                    {{ error }}
                </p>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                    <input v-model="form.name" type="text" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">SKU</label>
                    <input v-model="form.sku" type="text" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                    <select v-model="form.category_id" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                        <option value="">Select category</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Supplier</label>
                    <select v-model="form.supplier_id" class="w-full rounded-lg border px-3 py-2 text-sm outline-none">
                        <option value="">Select supplier</option>
                        <option
                            v-for="supplier in suppliers"
                            :key="supplier.id"
                            :value="supplier.id"
                        >
                            {{ supplier.name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description" rows="3" class="w-full rounded-lg border px-3 py-2 text-sm outline-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Cost Price</label>
                        <input v-model="form.cost_price" type="number" min="0" step="0.01" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Selling Price</label>
                        <input v-model="form.selling_price" type="number" min="0" step="0.01" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Stock</label>
                        <input v-model="form.stock" type="number" min="0" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Reorder Level</label>
                        <input v-model="form.reorder_level" type="number" min="0" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                    <select v-model="form.status" class="w-full rounded-lg border px-3 py-2 text-sm outline-none" required>
                        <option :value="true">Active</option>
                        <option :value="false">Inactive</option>
                    </select>
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
                        {{ loading ? 'Saving...' : 'Create' }}
                    </button>
                </div>
            </form>
        </ProductModal>
    </template>