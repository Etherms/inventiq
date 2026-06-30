<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import { Search } from 'lucide-vue-next'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import SupplierTable from '../Components/Suppliers/SupplierTable.vue'
import CreateSupplier from '../Components/Suppliers/CreateSupplier.vue'
import EditSupplier from '../Components/Suppliers/EditSupplier.vue'

const suppliers = ref([])
const loading = ref(false)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedSupplier = ref(null)

function editSupplier(supplier) {
    selectedSupplier.value = supplier
    showEditModal.value = true
}

async function deleteSupplier(supplier) {
    if (!confirm(`Delete ${supplier.name}?`)) return

    await axios.delete(`/api/suppliers/${supplier.id}`)
    fetchSuppliers()
}

async function fetchSuppliers() {
    loading.value = true
    try {
        const res = await axios.get('/api/suppliers')
        suppliers.value = res.data.data
    } catch (error) {
        console.error('Error fetching suppliers:', error)
    } finally {
        loading.value = false
    }
}


onMounted(() => {
    fetchSuppliers()
})
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

                <button
                    type="button"
                    @click="showCreateModal = true"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                >
                    + Create Supplier
                </button>
            </div>

            <div class="rounded-xl bg-white  shadow-sm flex py-5 pl-4">
                <Search class="h-4 w-4 text-gray-500" />
                <input
                    type="text"
                    placeholder="Search suppliers..."
                    class="w-full rounded-lg pr-6 ml-2 text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <SupplierTable
                    :suppliers="suppliers"
                    :loading="loading"
                    @edit="editSupplier"
                    @delete="deleteSupplier" />
            </div>
        </div>
        <CreateSupplier
            :show="showCreateModal"
            @close="showCreateModal = false"
            @created="fetchSuppliers"/>
        <EditSupplier
            :show="showEditModal"
            :supplier="selectedSupplier"
            @close="showEditModal = false"
            @updated="fetchSuppliers"
        />
    </AppLayout>
</template>