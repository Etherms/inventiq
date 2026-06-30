<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import { Search } from 'lucide-vue-next'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import ProductTable from '../Components/Products/ProductTable.vue'
import CreateProduct from '../Components/Products/CreateProduct.vue'

const loading = ref(false)
const products = ref([])
const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedProduct = ref(null)

function editProduct(product) {
    selectedProduct.value = product
    showEditModal.value = true
}

async function deleteProduct(product) {
    if (!confirm(`Delete ${product.name}?`)) return

    try {
        await axios.delete(`/api/products/${product.id}`)
        fetchProducts()
    } catch (error) {
        console.error('Error deleting product:', error)
    }
}

async function fetchProducts() {
    loading.value = true
    try {
        const res = await axios.get('/api/products')
        products.value = res.data.data
    } catch (error) {
        console.error('Error fetching products:', error)
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
            <div class="rounded-xl bg-white  shadow-sm flex py-5 pl-4">
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
                    @edit="editProduct"
                    @delete="deleteProduct" />
            </div>
        </div>
            <CreateProduct
            :show="showCreateModal"
            @close="showCreateModal = false"
            @created="fetchProducts"/>
    </AppLayout>
</template>