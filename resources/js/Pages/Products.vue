<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import { Search } from 'lucide-vue-next'
import { onMounted, ref } from 'vue'
import axios from 'axios'

import ProductTable from '../Components/Products/ProductTable.vue'
import CreateProduct from '../Components/Products/CreateProduct.vue'
import EditProduct from '../Components/Products/EditProduct.vue'
import StockInModal from '../Components/StockMovement/StockInModal.vue'
import StockOutModal from '../Components/StockMovement/StockOutModal.vue'

const loading = ref(false)
const products = ref([])
const pagination = ref({})

const showCreateModal = ref(false)
const showEditModal = ref(false)
const showStockInModal = ref(false)
const showStockOutModal = ref(false)

const selectedProduct = ref(null)
const success = ref('')

const sortBy = ref('created_at')
const sortDirection = ref('desc')

function sortProducts(column) {
    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortBy.value = column
        sortDirection.value = 'asc'
    }

    fetchProducts(1)
}

function showSuccess(message) {
    success.value = message

    setTimeout(() => {
        success.value = ''
    }, 3000)
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

    try {
        await axios.delete(`/api/products/${product.id}`)
        await fetchProducts()
        showSuccess('Product deleted successfully.')
    } catch (error) {
        console.error('Error deleting product:', error)
    }
}

async function handleStockInSaved() {
    showStockInModal.value = false
    selectedProduct.value = null

    await fetchProducts()
    showSuccess('Stock added successfully.')
}

async function handleStockOutSaved() {
    showStockOutModal.value = false
    selectedProduct.value = null

    await fetchProducts()
    showSuccess('Stock deducted successfully.')
}

async function handleProductCreated() {
    showCreateModal.value = false

    await fetchProducts()
    showSuccess('Product created successfully.')
}

async function handleProductUpdated() {
    showEditModal.value = false
    selectedProduct.value = null

    await fetchProducts()
    showSuccess('Product updated successfully.')
}

async function fetchProducts(page = 1) {
    loading.value = true

    try {
        const res = await axios.get('/api/products', {
            params: {
                page,
                sort_by: sortBy.value,
                sort_direction: sortDirection.value,
            },
        })

        products.value = res.data.data
        pagination.value = res.data
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchProducts()
})
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div
                v-if="success"
                class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ success }}
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Products
                    </h1>
                </div>

                <div class="flex gap-2">
                    <button
                        type="button"
                        @click="showCreateModal = true"
                        class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-black hover:bg-[#ededed] outline-1"
                    >
                        + Create Product
                    </button>

                    <button
                        type="button"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        + Import Product
                    </button>
                </div>
            </div>

            <div class="rounded-xl bg-white shadow-sm flex py-5 pl-4">
                <Search class="h-4 w-4 text-gray-500" />

                <input
                    type="text"
                    placeholder="Search products..."
                    class="w-full rounded-lg pr-6 ml-2 text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <ProductTable
                    :products="products"
                    :loading="loading"
                    :pagination="pagination"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
                    @sort="sortProducts"
                    @page-change="fetchProducts"
                    @stock-in="openStockIn"
                    @stock-out="openStockOut"
                    @edit="editProduct"
                    @delete="deleteProduct"
                />
            </div>
        </div>

        <CreateProduct
            :show="showCreateModal"
            @close="showCreateModal = false"
            @created="handleProductCreated"
        />

        <EditProduct
            :show="showEditModal"
            :product="selectedProduct"
            @close="showEditModal = false"
            @updated="handleProductUpdated"
        />

        <StockInModal
            :show="showStockInModal"
            :product="selectedProduct"
            @close="showStockInModal = false"
            @saved="handleStockInSaved"
        />

        <StockOutModal
            :show="showStockOutModal"
            :product="selectedProduct"
            @close="showStockOutModal = false"
            @saved="handleStockOutSaved"
        />
    </AppLayout>
</template>