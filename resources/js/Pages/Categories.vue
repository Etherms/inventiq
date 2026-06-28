<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import { Search } from 'lucide-vue-next'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import CategoryTable from '../Components/Categories/CategoryTable.vue'
import CreateCategory from '../Components/Categories/CreateCategory.vue'
import EditCategory from '../Components/Categories/EditCategory.vue'

const categories = ref([])
const loading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedCategory = ref(null)

function editCategory(category) {
    selectedCategory.value = category
    showEditModal.value = true
}

async function fetchCategories() {
    loading.value = true
    try {
        const res = await axios.get('/api/categories')
        categories.value = res.data.data
    } catch (error) {
        console.error('Error fetching categories:', error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchCategories()
})
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Categories
                    </h1>
                </div>

                <button
                    type="button"
                    @click="showCreateModal = true"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                >
                    + Create Category
                </button>
            </div>

            <div class="rounded-xl bg-white  shadow-sm flex py-5 pl-4">
                <Search class="h-4 w-4 text-gray-500" />
                <input
                    type="text"
                    placeholder="Search categories..."
                    class="w-full rounded-lg pr-6 ml-2 text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <CategoryTable
                    :categories="categories"
                    :loading="loading"
                    @edit="editCategory"
                />
            </div>
        </div>
        <CreateCategory
            :show="showCreateModal"
            @close="showCreateModal = false"
            @created="fetchCategories"
        />
        <EditCategory
            :show="showEditModal"
            :category="selectedCategory"
            @close="showEditModal = false"
            @updated="fetchCategories"
        />
    </AppLayout>
</template>