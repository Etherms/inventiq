<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DataTable from '../Components/Global/DataTable.vue'
import CreateSupplier from '../Components/Suppliers/CreateSupplier.vue'
import EditSupplier from '../Components/Suppliers/EditSupplier.vue'
import { Search, Upload, Download } from 'lucide-vue-next'
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'

const suppliers = ref([])
const pagination = ref({})
const fileInput = ref(null)
const loading = ref(false)

const search = ref('')
const currentPage = ref(1)
const sortBy = ref('created_at')
const sortDirection = ref('desc')

const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedSupplier = ref(null)

const columns = [
    { key: 'name', label: 'Name', sortable: true },
    { key: 'contact_person', label: 'Contact Person', sortable: true, fallback: '-' },
    { key: 'email', label: 'Email', sortable: true },
    { key: 'phone', label: 'Phone', sortable: true },
    { key: 'address', label: 'Address', sortable: true, fallback: '-' },
    { key: 'actions', label: 'Actions', class: 'text-right', align: 'right' },
]

function editSupplier(supplier) {
    selectedSupplier.value = supplier
    showEditModal.value = true
}

async function deleteSupplier(supplier) {
    if (!confirm(`Delete ${supplier.name}?`)) return

    await axios.delete(`/api/suppliers/${supplier.id}`)
    fetchSuppliers(currentPage.value)
}

async function fetchSuppliers(page = 1) {
    loading.value = true

    try {
        const res = await axios.get('/api/suppliers', {
            params: {
                page,
                search: search.value,
                sort_by: sortBy.value,
                sort_direction: sortDirection.value,
            },
        })

        suppliers.value = res.data.data
        pagination.value = res.data.pagination
        currentPage.value = res.data.pagination.current_page
    } finally {
        loading.value = false
    }
}

function handleSort(column) {
    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortBy.value = column
        sortDirection.value = 'asc'
    }

    fetchSuppliers(1)
}

function exportSuppliers() {
    window.location.href = '/api/import-export/suppliers/export'
}

function openImport() {
    fileInput.value.click()
}

async function importSuppliers(event) {
    const file = event.target.files[0]

    if (!file) return

    const formData = new FormData()
    formData.append('file', file)

    try {
        const res = await axios.post('/api/import-export/suppliers/import', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })

        const duplicates = res.data.duplicates || []

        if (duplicates.length > 0) {
            alert(
                `Import completed.\n\nImported: ${res.data.imported}\nDuplicates found: ${res.data.duplicates_count}\n\nDuplicates:\n- ${duplicates.join('\n- ')}`
            )
        } else {
            alert(`Import completed.\n\nImported: ${res.data.imported}\nNo duplicates found.`)
        }

        event.target.value = ''
        fetchSuppliers(1)
    } catch (error) {
        console.error('Error importing suppliers:', error)
        alert('Import failed. Please check your CSV file.')
    }
}

watch(search, () => fetchSuppliers(1))

onMounted(() => fetchSuppliers())
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Suppliers
                    </h1>
                </div>

                <div class="flex flex-wrap gap-2">
                    <input
                        ref="fileInput"
                        type="file"
                        accept=".csv"
                        class="hidden"
                        @change="importSuppliers"
                    >

                    <button
                        type="button"
                        @click="openImport"
                        class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <Upload class="h-4 w-4" />
                        Import
                    </button>

                    <button
                        type="button"
                        @click="exportSuppliers"
                        class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <Download class="h-4 w-4" />
                        Export
                    </button>

                    <button
                        type="button"
                        @click="showCreateModal = true"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        + Create Supplier
                    </button>
                </div>
            </div>

            <div class="flex items-center rounded-xl bg-white px-4 py-4 shadow-sm">
                <Search class="h-4 w-4 text-gray-500" />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search suppliers..."
                    class="ml-2 w-full text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <DataTable
                    :rows="suppliers"
                    :columns="columns"
                    :loading="loading"
                    :pagination="pagination"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
                    loading-message="Loading suppliers..."
                    empty-message="No suppliers found."
                    @edit="editSupplier"
                    @delete="deleteSupplier"
                    @sort="handleSort"
                    @page-change="fetchSuppliers"
                />
            </div>
        </div>

        <CreateSupplier
            :show="showCreateModal"
            @close="showCreateModal = false"
            @created="fetchSuppliers(1)"
        />

        <EditSupplier
            :show="showEditModal"
            :supplier="selectedSupplier"
            @close="showEditModal = false"
            @updated="fetchSuppliers(currentPage)"
        />
    </AppLayout>
</template>