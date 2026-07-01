<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import AppLayout from '../Layouts/AppLayout.vue'
import StockStatistics from '../Components/StockMovement/StockStatistics.vue'
import StockMovementTable from '../Components/StockMovement/StockMovementTable.vue'
import StockMovementDetailsModal from '../Components/StockMovement/StockMovementDetailsModal.vue'

const stats = ref({
    totalMovements: 0,
    stockIn: 0,
    stockOut: 0,
    todayMovements: 0,
})

const movements = ref([])
const loading = ref(false)
const selectedMovement = ref(null)
const showDetailsModal = ref(false)

async function fetchStats() {
    const res = await axios.get('/stock-movements/statistics')
    stats.value = res.data.data
}

async function fetchMovements() {
    loading.value = true

    try {
        const res = await axios.get('/stock-movements/list')
        movements.value = res.data.data
    } finally {
        loading.value = false
    }
}

function openMovementDetails(movement) {
    selectedMovement.value = movement
    showDetailsModal.value = true
}

onMounted(() => {
    fetchStats()
    fetchMovements()
})
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Stock Movements
                </h1>
                <p class="text-sm text-gray-500">
                    Track all inventory stock in and stock out transactions.
                </p>
            </div>

            <StockStatistics :stats="stats" />

            <StockMovementTable
                :movements="movements"
                :loading="loading"
                @view="openMovementDetails"
            />

            <StockMovementDetailsModal
                :show="showDetailsModal"
                :movement="selectedMovement"
                @close="showDetailsModal = false"
            />
        </div>
    </AppLayout>
</template>