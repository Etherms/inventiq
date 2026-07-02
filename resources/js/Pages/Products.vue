<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DataTable from '../Components/Global/DataTable.vue'
import CreateProduct from '../Components/Products/CreateProduct.vue'
import EditProduct from '../Components/Products/EditProduct.vue'
import StockInModal from '../Components/StockMovement/StockInModal.vue'
import StockOutModal from '../Components/StockMovement/StockOutModal.vue'

import { Search, Pencil, Trash2, Plus, Minus, Upload, Download } from 'lucide-vue-next'
import { useProducts } from '../Composables/Products/useProducts.js'

const {
    loading,
    products,
    pagination,
    fileInput,
    search,
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
} = useProducts()
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

                <div class="flex flex-wrap gap-2">
                    <input
                        ref="fileInput"
                        type="file"
                        accept=".csv"
                        class="hidden"
                        @change="importProducts"
                    >

                    <button
                        @click="openImport"
                        class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <Upload class="h-4 w-4" />
                        Import
                    </button>

                    <button
                        @click="exportProducts"
                        class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <Download class="h-4 w-4" />
                        Export
                    </button>

                    <button
                        @click="showCreateModal = true"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        + Create Product
                    </button>
                </div>
            </div>

            <div class="flex items-center rounded-xl bg-white px-4 py-4 shadow-sm">
                <Search class="h-4 w-4 text-gray-500" />

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search products..."
                    class="ml-2 w-full text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <DataTable
                    :rows="products"
                    :columns="columns"
                    :loading="loading"
                    :pagination="pagination"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
                    loading-message="Loading products..."
                    empty-message="No products found."
                    @sort="sortProducts"
                    @page-change="fetchProducts"
                >
                    <template #cell-selling_price="{ value }">
                        ₱{{ Number(value).toFixed(2) }}
                    </template>

                    <template #cell-supplier="{ row }">
                        {{ row.supplier?.name || 'No supplier' }}
                    </template>

                    <template #cell-category="{ row }">
                        {{ row.category?.name || 'No category' }}
                    </template>

                    <template #cell-status="{ row }">
                        <span
                            class="rounded-full px-2 py-1 text-xs font-medium"
                            :class="row.status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                        >
                            {{ row.status ? 'Available' : 'Unavailable' }}
                        </span>
                    </template>

                    <template #cell-actions="{ row }">
                        <div class="flex justify-end gap-2">
                            <button
                                type="button"
                                @click="openStockIn(row)"
                                class="rounded-lg border p-2 text-green-600 hover:bg-green-50"
                                title="Stock In"
                            >
                                <Plus class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="openStockOut(row)"
                                class="rounded-lg border p-2 text-orange-600 hover:bg-orange-50"
                                title="Stock Out"
                            >
                                <Minus class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="editProduct(row)"
                                class="rounded-lg border p-2 text-gray-600 hover:bg-gray-100"
                                title="Edit"
                            >
                                <Pencil class="h-4 w-4" />
                            </button>

                            <button
                                type="button"
                                @click="deleteProduct(row)"
                                class="rounded-lg border p-2 text-red-600 hover:bg-red-50"
                                title="Delete"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </template>
                </DataTable>
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