<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import DataTable from '../Components/Global/DataTable.vue'
import CreateCategory from '../Components/Categories/CreateCategory.vue'
import EditCategory from '../Components/Categories/EditCategory.vue'
import { Search, Upload, Download } from 'lucide-vue-next'
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'

const categories = ref([])
const pagination = ref({})
const loading = ref(false)

const search = ref('')
const currentPage = ref(1)
const sortBy = ref('created_at')
const sortDirection = ref('desc')

const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedCategory = ref(null)
const fileInput = ref(null)

const columns = [
    { key: 'name', label: 'Name', sortable: true, fallback: '-' },
    { key: 'description', label: 'Description', sortable: true, fallback: 'No description' },
    { key: 'created_at', label: 'Date Created', sortable: true, type: 'date' },
    { key: 'actions', label: 'Actions', class: 'text-right', align: 'right' },
]

function editCategory(category) {
    selectedCategory.value = category
    showEditModal.value = true
}

async function deleteCategory(category) {
    if (!confirm(`Delete ${category.name}?`)) return

    try {
        await axios.delete(`/api/categories/${category.id}`)
        fetchCategories(currentPage.value)
    } catch (error) {
        alert(error.response?.data?.message || 'Delete failed.')
    }
}

async function fetchCategories(page = 1) {
    loading.value = true

    try {
        const res = await axios.get('/api/categories', {
            params: {
                page,
                search: search.value,
                sort_by: sortBy.value,
                sort_direction: sortDirection.value,
            },
        })

        categories.value = res.data.data
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

    fetchCategories(1)
}

function exportCategories() {
    window.location.href = '/api/import-export/categories/export'
}

function openImport() {
    fileInput.value.click()
}

async function importCategories(event) {
    const file = event.target.files[0]
    if (!file) return

    const formData = new FormData()
    formData.append('file', file)

    await axios.post('/api/import-export/categories/import', formData)

    event.target.value = ''
    fetchCategories(1)
}

watch(search, () => fetchCategories(1))

onMounted(() => fetchCategories())
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
                    <p class="text-sm text-gray-500">
                        Manage product categories.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <input
                        ref="fileInput"
                        type="file"
                        accept=".csv"
                        class="hidden"
                        @change="importCategories"
                    >

                    <button @click="openImport" class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm">
                        <Upload class="h-4 w-4" />
                        Import
                    </button>

                    <button @click="exportCategories" class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm">
                        <Download class="h-4 w-4" />
                        Export
                    </button>

                    <button
                        @click="showCreateModal = true"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white"
                    >
                        + Create Category
                    </button>
                </div>
            </div>

            <div class="flex items-center rounded-xl bg-white px-4 py-4 shadow-sm">
                <Search class="h-4 w-4 text-gray-500" />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search categories..."
                    class="ml-2 w-full text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <DataTable
                    :rows="categories"
                    :columns="columns"
                    :loading="loading"
                    :pagination="pagination"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
                    loading-message="Loading categories..."
                    empty-message="No categories found."
                    @edit="editCategory"
                    @delete="deleteCategory"
                    @sort="handleSort"
                    @page-change="fetchCategories"
                />
            </div>
        </div>

        <CreateCategory
            :show="showCreateModal"
            @close="showCreateModal = false"
            @created="fetchCategories(1)"
        />

        <EditCategory
            :show="showEditModal"
            :category="selectedCategory"
            @close="showEditModal = false"
            @updated="fetchCategories(currentPage)"
        />
    </AppLayout>
</template>