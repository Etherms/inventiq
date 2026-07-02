import { ref, watch, onMounted } from 'vue'
import axios from 'axios'

export function useProducts() {
    const loading = ref(false)
    const products = ref([])
    const pagination = ref({})
    const fileInput = ref(null)

    const search = ref('')
    const currentPage = ref(1)
    const sortBy = ref('created_at')
    const sortDirection = ref('desc')

    const selectedProduct = ref(null)
    const success = ref('')

    const showCreateModal = ref(false)
    const showEditModal = ref(false)
    const showStockInModal = ref(false)
    const showStockOutModal = ref(false)

    const columns = [
        { key: 'name', label: 'Product', sortable: true },
        { key: 'selling_price', label: 'Price', sortable: true },
        { key: 'stock', label: 'Qty', sortable: true },
        { key: 'supplier', label: 'Supplier', sortable: false },
        { key: 'category', label: 'Category', sortable: false },
        { key: 'status', label: 'Availability', sortable: true },
        { key: 'actions', label: 'Action', align: 'right', class: 'text-right' },
    ]

    function showSuccess(message) {
        success.value = message

        setTimeout(() => {
            success.value = ''
        }, 3000)
    }

    async function fetchProducts(page = 1) {
        loading.value = true

        try {
            const res = await axios.get('/api/products', {
                params: {
                    page,
                    search: search.value,
                    sort_by: sortBy.value,
                    sort_direction: sortDirection.value,
                },
            })

            products.value = res.data.data
            pagination.value = res.data.pagination
            currentPage.value = res.data.pagination.current_page
        } finally {
            loading.value = false
        }
    }

    function sortProducts(column) {
        if (sortBy.value === column) {
            sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
        } else {
            sortBy.value = column
            sortDirection.value = 'asc'
        }

        fetchProducts(1)
    }

    function openStockIn(product) {
        selectedProduct.value = product
        showStockInModal.value = true
    }

    function openStockOut(product) {
        selectedProduct.value = product
        showStockOutModal.value = true
    }

    function editProduct(product) {
        selectedProduct.value = product
        showEditModal.value = true
    }

    async function deleteProduct(product) {
        if (!confirm(`Delete ${product.name}?`)) return

        await axios.delete(`/api/products/${product.id}`)
        await fetchProducts(currentPage.value)
        showSuccess('Product deleted successfully.')
    }

    function exportProducts() {
        window.location.href = '/api/import-export/products/export'
    }

    function openImport() {
        fileInput.value.click()
    }

    async function importProducts(event) {
        const file = event.target.files[0]
        if (!file) return

        const formData = new FormData()
        formData.append('file', file)

        const res = await axios.post('/api/import-export/products/import', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })

        alert(`Import completed. Imported: ${res.data.imported}`)

        event.target.value = ''
        fetchProducts(1)
    }

    async function handleStockInSaved() {
        showStockInModal.value = false
        selectedProduct.value = null
        await fetchProducts(currentPage.value)
        showSuccess('Stock added successfully.')
    }

    async function handleStockOutSaved() {
        showStockOutModal.value = false
        selectedProduct.value = null
        await fetchProducts(currentPage.value)
        showSuccess('Stock deducted successfully.')
    }

    async function handleProductCreated() {
        showCreateModal.value = false
        await fetchProducts(1)
        showSuccess('Product created successfully.')
    }

    async function handleProductUpdated() {
        showEditModal.value = false
        selectedProduct.value = null
        await fetchProducts(currentPage.value)
        showSuccess('Product updated successfully.')
    }

    watch(search, () => {
        fetchProducts(1)
    })

    onMounted(() => {
        fetchProducts()
    })

    return {
        loading,
        products,
        pagination,
        fileInput,
        search,
        currentPage,
        sortBy,
        sortDirection,
        selectedProduct,
        success,
        showCreateModal,
        showEditModal,
        showStockInModal,
        showStockOutModal,
        columns,

        fetchProducts,
        sortProducts,
        openStockIn,
        openStockOut,
        editProduct,
        deleteProduct,
        exportProducts,
        openImport,
        importProducts,
        handleStockInSaved,
        handleStockOutSaved,
        handleProductCreated,
        handleProductUpdated,
    }
}