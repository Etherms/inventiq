import { onMounted, ref } from 'vue'
import axios from 'axios'

export function useCreateProduct(emit) {
    const categories = ref([])
    const suppliers = ref([])

    const defaultForm = () => ({
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

    const form = ref(defaultForm())

    const loading = ref(false)
    const error = ref('')

    async function fetchDropdowns() {
        const [categoryRes, supplierRes] = await Promise.all([
            axios.get('/api/categories', {
                params: { per_page: 999 },
            }),
            axios.get('/api/suppliers', {
                params: { per_page: 999 },
            }),
        ])

        categories.value = categoryRes.data.data
        suppliers.value = supplierRes.data.data
    }

    async function submit() {
        loading.value = true
        error.value = ''

        try {
            const payload = {
                ...form.value,
                category_id: Number(form.value.category_id),
                supplier_id: form.value.supplier_id
                    ? Number(form.value.supplier_id)
                    : null,
                status: Boolean(form.value.status),
            }

            const res = await axios.post('/api/products', payload)

            emit('created', res.data.data)
            emit('close')

            form.value = defaultForm()
        } catch (e) {
            error.value = e.response?.data?.message || 'Failed to create product.'
        } finally {
            loading.value = false
        }
    }

    onMounted(fetchDropdowns)

    return {
        categories,
        suppliers,
        form,
        loading,
        error,
        submit,
    }
}