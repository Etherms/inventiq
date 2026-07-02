<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import { Search, Upload, Download } from 'lucide-vue-next'
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'
import CategoryTable from '../Components/Categories/CategoryTable.vue'
import CreateCategory from '../Components/Categories/CreateCategory.vue'
import EditCategory from '../Components/Categories/EditCategory.vue'

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

const successMessage = ref('')
const errorMessage = ref('')


function editCategory(category) {
    selectedCategory.value = category
    showEditModal.value = true
}

async function deleteCategory(category) {
    if (!confirm(`Delete ${category.name}?`)) return

    successMessage.value = ''
    errorMessage.value = ''

    try {
        const res = await axios.delete(`/api/categories/${category.id}`)

        categories.value = categories.value.filter(
            item => item.id !== category.id
        )

        successMessage.value =
            res.data.message || 'Category deleted successfully.'
    } catch (error) {
        errorMessage.value =
            error.response?.data?.message ||
            'Delete failed. Please try again.'
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
        currentPage.value = page
    } catch (error) {
        console.error('Error fetching categories:', error)
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
    window.location.href = '/api/categories/export'
}

function openImport() {
    fileInput.value.click()
}

async function importCategories(event) {
    const file = event.target.files[0]

    if (!file) return

    const formData = new FormData()
    formData.append('file', file)

    try {
        const res = await axios.post('/api/categories/import', formData, {
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
        fetchCategories(1)
    } catch (error) {
        console.error('Error importing categories:', error)
        alert('Import failed. Please check your CSV file.')
    }
}

watch(search, () => {
    fetchCategories(1)
})

onMounted(() => {
    fetchCategories()
})
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Categories
                    </h1>
                    <p class="text-sm text-gray-500">
                        Manage product categories, import records, and export category data.
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
                        @click="exportCategories"
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
                        + Create Category
                    </button>
                </div>
            </div>
            <div
                v-if="successMessage"
                class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ successMessage }}
            </div>

            <div
                v-if="errorMessage"
                class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
            >
                {{ errorMessage }}
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
                <CategoryTable
                    :categories="categories"
                    :loading="loading"
                    :pagination="pagination"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
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