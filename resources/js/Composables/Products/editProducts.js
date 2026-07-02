import { onMounted, ref, watch } from 'vue'
import axios from 'axios'

export function useEditProduct(props, emit) {
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

    watch(
        () => props.product,
        (product) => {
            if (!product) return

            const categoryId = product.category_id ?? product.category?.id ?? ''
            const supplierId = product.supplier_id ?? product.supplier?.id ?? ''

            form.value = {
                category_id: categoryId ? Number(categoryId) : '',
                supplier_id: supplierId ? Number(supplierId) : '',
                sku: product.sku || '',
                name: product.name || '',
                description: product.description || '',
                cost_price: product.cost_price || '',
                selling_price: product.selling_price || '',
                stock: product.stock || '',
                reorder_level: product.reorder_level || '',
                status: Boolean(product.status),
            }
        },
        { immediate: true }
    )

    async function submit() {
        if (!props.product) return

        loading.value = true
        error.value = ''

        try {
            const res = await axios.put(`/api/products/${props.product.id}`, form.value)

            emit('updated', res.data.data)
            emit('close')
        } catch (e) {
            error.value = e.response?.data?.message || 'Failed to update product.'
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