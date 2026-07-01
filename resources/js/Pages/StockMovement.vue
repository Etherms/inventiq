<script setup>
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'
import AppLayout from '../Layouts/AppLayout.vue'
import StockStatistics from '../Components/StockMovement/StockStatistics.vue'
import StockMovementTable from '../Components/StockMovement/StockMovementTable.vue'
import StockMovementDetailsModal from '../Components/StockMovement/StockMovementDetailsModal.vue'
import StockMovementFilters from '../Components/StockMovement/StockMovementFilters.vue'
import StockMovementActions from '../Components/StockMovement/StockMovementActions.vue'

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

const sortBy = ref('created_at')
const sortDirection = ref('desc')
const activeFilter = ref('all')

const filters = ref({
    search: '',
    date_range: null,
})

const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 8,
    total: 0,
    from: 0,
    to: 0,
    prev_page_url: null,
    next_page_url: null,
})

let filterTimeout = null

watch(
    filters,
    () => {
        clearTimeout(filterTimeout)

        filterTimeout = setTimeout(() => {
            fetchMovements(1)
        }, 400)
    },
    { deep: true }
)

function filterMovements(filter) {
    activeFilter.value = filter
    fetchMovements(1)
}

function sortMovements(column) {
    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortBy.value = column
        sortDirection.value = 'asc'
    }

    fetchMovements(1)
}

function changePage(page) {
    fetchMovements(page)
}

async function fetchStats() {
    try {
        const res = await axios.get('/stock-movements/statistics')
        stats.value = res.data.data
    } catch (error) {
        console.error('Error fetching stats:', error)
    }
}

async function fetchMovements(page = 1) {
    loading.value = true

    let dateFrom = ''
    let dateTo = ''

    if (Array.isArray(filters.value.date_range)) {
        dateFrom = filters.value.date_range[0] || ''
        dateTo = filters.value.date_range[1] || filters.value.date_range[0] || ''
    }

    try {
        const res = await axios.get('/stock-movements/list', {
            params: {
                page,
                per_page: pagination.value.per_page,
                sort_by: sortBy.value,
                sort_direction: sortDirection.value,
                filter: activeFilter.value,
                search: filters.value.search,
                date_from: dateFrom,
                date_to: dateTo,
            },
        })

        movements.value = res.data.data
        pagination.value = res.data
    } catch (error) {
        console.error('Error fetching movements:', error)
    } finally {
        loading.value = false
    }
}

function exportMovements() {
    let dateFrom = ''
    let dateTo = ''

    if (Array.isArray(filters.value.date_range)) {
        dateFrom = filters.value.date_range[0] || ''
        dateTo = filters.value.date_range[1] || filters.value.date_range[0] || ''
    }

    const query = new URLSearchParams({
        sort_by: sortBy.value,
        sort_direction: sortDirection.value,
        filter: activeFilter.value,
        search: filters.value.search || '',
        date_from: dateFrom,
        date_to: dateTo,
    }).toString()

    window.location.href = `/stock-movements/export?${query}`
}

async function importMovements(file) {
    if (!file) return

    const formData = new FormData()
    formData.append('file', file)

    try {
        await axios.post('/stock-movements/import', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })

        fetchStats()
        fetchMovements(1)
    } catch (error) {
        console.error('Error importing movements:', error)
    }
}

function resetFilters() {
    filters.value = {
        search: '',
        date_range: null,
    }

    fetchMovements(1)
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
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Stock Movements
                    </h1>
                    <p class="text-sm text-gray-500">
                        Track all inventory stock in and stock out transactions.
                    </p>
                </div>

                <StockMovementActions
                    @export="exportMovements"
                    @import="importMovements"
                />
            </div>

            <StockStatistics
                :stats="stats"
                :active-filter="activeFilter"
                @filter="filterMovements"
            />

            <StockMovementFilters
                v-model:filters="filters"
                @reset="resetFilters"
            />

            <StockMovementTable
                :movements="movements"
                :loading="loading"
                :pagination="pagination"
                :sort-by="sortBy"
                :sort-direction="sortDirection"
                @sort="sortMovements"
                @page-change="changePage"
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